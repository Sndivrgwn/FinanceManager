<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    private const PRESETS = [
        'this_month' => 'Bulan Ini',
        'last_month' => 'Bulan Lalu',
        'last_3_months' => '3 Bulan Terakhir',
        'this_year' => 'Tahun Ini',
    ];

    public function index(Request $request)
    {
        $validator = $this->periodValidator($request);

        if ($validator->fails()) {
            // Kembali ke periode default beserta pesan error.
            return redirect()->route('dashboard')->withErrors($validator);
        }

        [$period, $start, $end] = $this->resolvePeriod($request);

        $user = $request->user();
        $userId = $user->id;
        $from = $start->toDateString();
        $to = $end->toDateString();

        // 1) Total saldo: dari saldo wallet saat ini (bukan dari transaksi).
        $totalBalance = (float) $user->wallets()->sum('balance');

        // 2) Total pemasukan & pengeluaran periode terpilih: satu query agregat.
        //    Hanya tabel transactions, sehingga transfer otomatis tidak ikut terhitung.
        $totals = DB::table('transactions')
            ->where('user_id', $userId)
            ->whereBetween('transaction_date', [$from, $to])
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'INCOME' THEN amount END), 0) AS total_income")
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'EXPENSE' THEN amount END), 0) AS total_expense")
            ->first();

        $totalIncome = (float) $totals->total_income;
        $totalExpense = (float) $totals->total_expense;
        $netCashFlow = round($totalIncome - $totalExpense, 2);

        // 3) Wallet overview.
        $wallets = $user->wallets()->orderBy('name')->get();

        // 4) Transaksi terbaru (tidak dipengaruhi filter periode).
        $recentTransactions = $user->transactions()
            ->with(['wallet:id,name', 'category:id,name'])
            ->latest('transaction_date')
            ->latest('id')
            ->limit(8)
            ->get();

        // 5) Pengeluaran per kategori pada periode terpilih.
        $categoryRows = DB::table('transactions')
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->where('transactions.user_id', $userId)
            ->where('transactions.type', 'EXPENSE')
            ->whereBetween('transactions.transaction_date', [$from, $to])
            ->groupBy('categories.id', 'categories.name')
            ->selectRaw('categories.name AS name, SUM(transactions.amount) AS total')
            ->orderByDesc('total')
            ->get();

        $expenseByCategory = $this->buildCategoryBreakdown($categoryRows, $totalExpense);

        // 6) Data grafik pemasukan vs pengeluaran.
        $chart = $this->incomeExpenseSeries($userId, $start, $end);
        $hasChartData = $totalIncome > 0 || $totalExpense > 0;

        $presets = self::PRESETS;

        return view('dashboard.index', compact(
            'period',
            'presets',
            'start',
            'end',
            'totalBalance',
            'totalIncome',
            'totalExpense',
            'netCashFlow',
            'wallets',
            'recentTransactions',
            'expenseByCategory',
            'chart',
            'hasChartData'
        ));
    }

    private function periodValidator(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'period' => ['nullable', Rule::in([...array_keys(self::PRESETS), 'custom'])],
            'start_date' => ['required_if:period,custom', 'nullable', 'date_format:Y-m-d'],
            'end_date' => [
                'required_if:period,custom',
                'nullable',
                'date_format:Y-m-d',
                'after_or_equal:start_date',
            ],
        ], [], [
            'start_date' => 'tanggal mulai',
            'end_date' => 'tanggal akhir',
        ]);

        // Batasi rentang kustom maksimal 5 tahun supaya data grafik tetap ringan.
        $validator->after(function ($validator) use ($request) {
            if ($validator->errors()->isNotEmpty() || $request->query('period') !== 'custom') {
                return;
            }

            $start = Carbon::createFromFormat('Y-m-d', $request->query('start_date'));
            $end = Carbon::createFromFormat('Y-m-d', $request->query('end_date'));

            if ($start->copy()->addYears(5)->lt($end)) {
                $validator->errors()->add('end_date', 'Rentang tanggal maksimal 5 tahun.');
            }
        });

        return $validator;
    }

    /**
     * @return array{0: string, 1: Carbon, 2: Carbon}
     */
    private function resolvePeriod(Request $request): array
    {
        $period = $request->query('period') ?: 'this_month';

        [$start, $end] = match ($period) {
            'last_month' => [
                now()->subMonthNoOverflow()->startOfMonth(),
                now()->subMonthNoOverflow()->endOfMonth(),
            ],
            'last_3_months' => [
                now()->subMonthsNoOverflow(2)->startOfMonth(),
                now()->endOfMonth(),
            ],
            'this_year' => [
                now()->startOfYear(),
                now()->endOfYear(),
            ],
            'custom' => [
                Carbon::createFromFormat('Y-m-d', $request->query('start_date'))->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $request->query('end_date'))->endOfDay(),
            ],
            default => [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ],
        };

        return [$period, $start, $end];
    }

    /**
     * Ambil 7 kategori teratas, sisanya digabung menjadi "Lainnya".
     */
    private function buildCategoryBreakdown(Collection $rows, float $totalExpense, int $limit = 7): array
    {
        $items = $rows->take($limit)->map(fn ($row) => [
            'name' => $row->name,
            'total' => (float) $row->total,
        ]);

        $others = (float) $rows->slice($limit)->sum('total');

        if ($others > 0) {
            $items->push(['name' => 'Lainnya', 'total' => $others]);
        }

        return $items->map(fn ($item) => $item + [
            'percent' => $totalExpense > 0
                ? round($item['total'] / $totalExpense * 100, 1)
                : 0,
        ])->values()->all();
    }

    /**
     * Pemasukan vs pengeluaran per hari (periode <= 62 hari) atau per bulan.
     * Agregasi dilakukan di database; PHP hanya mengisi bucket kosong dengan 0.
     */
    private function incomeExpenseSeries(int $userId, Carbon $start, Carbon $end): array
    {
        $daily = $start->copy()->startOfDay()->diffInDays($end->copy()->startOfDay()) <= 62;
        $sqlFormat = $daily ? '%Y-%m-%d' : '%Y-%m';

        $rows = DB::table('transactions')
            ->where('user_id', $userId)
            ->whereBetween('transaction_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw("DATE_FORMAT(transaction_date, '{$sqlFormat}') AS bucket")
            ->selectRaw("SUM(CASE WHEN type = 'INCOME' THEN amount ELSE 0 END) AS income")
            ->selectRaw("SUM(CASE WHEN type = 'EXPENSE' THEN amount ELSE 0 END) AS expense")
            ->groupBy('bucket')
            ->get()
            ->keyBy('bucket');

        $labels = [];
        $income = [];
        $expense = [];

        $cursor = $daily ? $start->copy()->startOfDay() : $start->copy()->startOfMonth();

        while ($cursor->lte($end)) {
            $row = $rows->get($cursor->format($daily ? 'Y-m-d' : 'Y-m'));

            $labels[] = $daily
                ? $cursor->translatedFormat('j M')
                : $cursor->translatedFormat('M Y');
            $income[] = $row ? (float) $row->income : 0;
            $expense[] = $row ? (float) $row->expense : 0;

            $cursor = $daily ? $cursor->addDay() : $cursor->addMonth();
        }

        return [
            'labels' => $labels,
            'income' => $income,
            'expense' => $expense,
        ];
    }
}