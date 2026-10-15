@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Header --}}
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
        <p class="text-sm text-slate-500">
            Periode: {{ Format::date($start) }} &ndash; {{ Format::date($end) }}
        </p>
    </div>

    {{-- Error filter --}}
    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Filter periode --}}
    <section class="mb-6 rounded-xl border border-slate-200 bg-white p-4">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="flex flex-wrap gap-2">
                @foreach ($presets as $key => $label)
                    <a href="{{ route('dashboard', ['period' => $key]) }}"
                       class="rounded-full px-4 py-2 text-sm font-medium {{ $period === $key ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-end gap-2">
                <input type="hidden" name="period" value="custom">

                <div>
                    <label for="start_date" class="mb-1 block text-xs font-medium text-slate-500">Dari</label>
                    <input type="date" id="start_date" name="start_date" required
                           value="{{ $period === 'custom' ? $start->toDateString() : '' }}"
                           class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="end_date" class="mb-1 block text-xs font-medium text-slate-500">Sampai</label>
                    <input type="date" id="end_date" name="end_date" required
                           value="{{ $period === 'custom' ? $end->toDateString() : '' }}"
                           class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                </div>

                <button type="submit"
                        class="rounded-md px-4 py-2 text-sm font-medium {{ $period === 'custom' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Kustom
                </button>
            </form>
        </div>
    </section>

    {{-- Kartu statistik --}}
    <section class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm font-medium text-slate-500">Total Saldo</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ Format::rupiah($totalBalance) }}</p>
            <p class="mt-1 text-xs text-slate-400">Saldo seluruh wallet saat ini</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm font-medium text-slate-500">Total Pemasukan</p>
            <p class="mt-2 text-2xl font-bold text-emerald-600">{{ Format::rupiah($totalIncome) }}</p>
            <p class="mt-1 text-xs text-slate-400">Pada periode terpilih</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm font-medium text-slate-500">Total Pengeluaran</p>
            <p class="mt-2 text-2xl font-bold text-red-600">{{ Format::rupiah($totalExpense) }}</p>
            <p class="mt-1 text-xs text-slate-400">Pada periode terpilih</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm font-medium text-slate-500">Arus Kas Bersih</p>
            <p class="mt-2 text-2xl font-bold {{ $netCashFlow < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                {{ $netCashFlow > 0 ? '+' : '' }}{{ Format::rupiah($netCashFlow) }}
            </p>
            <p class="mt-1 text-xs text-slate-400">Pemasukan dikurangi pengeluaran</p>
        </div>
    </section>

    {{-- Grafik & pengeluaran per kategori --}}
    <section class="mb-6 grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5 lg:col-span-2">
            <h2 class="mb-4 text-base font-semibold text-slate-900">Pemasukan vs Pengeluaran</h2>

            @if ($hasChartData)
                <div class="relative h-72">
                    <canvas id="incomeExpenseChart"></canvas>
                </div>
            @else
                <p class="py-16 text-center text-sm text-slate-400">
                    Belum ada transaksi pada periode ini.
                </p>
            @endif
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <h2 class="mb-4 text-base font-semibold text-slate-900">Pengeluaran per Kategori</h2>

            <div class="space-y-4">
                @forelse ($expenseByCategory as $item)
                    <div>
                        <div class="mb-1 flex items-center justify-between gap-2 text-sm">
                            <span class="truncate font-medium text-slate-700">{{ $item['name'] }}</span>
                            <span class="shrink-0 text-slate-500">
                                {{ Format::rupiah($item['total']) }} ({{ rtrim(rtrim(number_format($item['percent'], 1, ',', '.'), '0'), ',') }}%)
                            </span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-red-500" style="width: {{ $item['percent'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="py-10 text-center text-sm text-slate-400">
                        Belum ada pengeluaran pada periode ini.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Wallet & transaksi terbaru --}}
    <section class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-semibold text-slate-900">Wallet</h2>
                <a href="{{ route('wallets.index') }}" class="text-sm text-slate-500 hover:text-slate-900">Kelola</a>
            </div>

            <ul class="divide-y divide-slate-100">
                @forelse ($wallets as $wallet)
                    <li class="flex items-center justify-between gap-3 py-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-800">{{ $wallet->name }}</p>
                            <span class="mt-1 inline-block rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">
                                {{ Format::walletType($wallet->type) }}
                            </span>
                        </div>
                        <p class="shrink-0 text-sm font-semibold text-slate-900">{{ Format::rupiah($wallet->balance) }}</p>
                    </li>
                @empty
                    <li class="py-8 text-center text-sm text-slate-400">
                        Belum ada wallet.
                        <a href="{{ route('wallets.create') }}" class="font-medium text-slate-700 underline">Buat wallet</a>
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 lg:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-semibold text-slate-900">Transaksi Terbaru</h2>
                <a href="{{ route('transactions.index') }}" class="text-sm text-slate-500 hover:text-slate-900">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-xs uppercase text-slate-500">
                            <th class="py-2 pr-4 font-medium">Tanggal</th>
                            <th class="py-2 pr-4 font-medium">Kategori</th>
                            <th class="py-2 pr-4 font-medium">Wallet</th>
                            <th class="py-2 pr-4 font-medium">Tipe</th>
                            <th class="py-2 text-right font-medium">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentTransactions as $transaction)
                            <tr>
                                <td class="whitespace-nowrap py-3 pr-4 text-slate-600">{{ Format::date($transaction->transaction_date) }}</td>
                                <td class="py-3 pr-4 text-slate-800">{{ $transaction->category?->name ?? '-' }}</td>
                                <td class="py-3 pr-4 text-slate-600">{{ $transaction->wallet?->name ?? '-' }}</td>
                                <td class="py-3 pr-4">
                                    <span class="rounded-full px-2 py-0.5 text-xs font-medium {{ $transaction->type === 'INCOME' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                        {{ $transaction->type === 'INCOME' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap py-3 text-right font-semibold {{ $transaction->type === 'INCOME' ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'INCOME' ? '+' : '-' }}{{ Format::rupiah($transaction->amount) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Belum ada transaksi.
                                    <a href="{{ route('transactions.create') }}" class="font-medium text-slate-700 underline">Tambah transaksi</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@if ($hasChartData)
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.js"></script>
        <script>
            const chartData = @json($chart);
            const rupiah = (value) => 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(value);

            new Chart(document.getElementById('incomeExpenseChart'), {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        { label: 'Pemasukan', data: chartData.income, backgroundColor: '#10b981', borderRadius: 4 },
                        { label: 'Pengeluaran', data: chartData.expense, backgroundColor: '#ef4444', borderRadius: 4 },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        y: { beginAtZero: true, ticks: { callback: (value) => rupiah(value) } },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: { label: (ctx) => ctx.dataset.label + ': ' + rupiah(ctx.parsed.y) },
                        },
                    },
                },
            });
        </script>
    @endpush
@endif