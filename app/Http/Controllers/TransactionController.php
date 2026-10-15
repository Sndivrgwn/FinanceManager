<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()
            ->transactions()
            ->with(['wallet', 'category'])
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $user = auth()->user();

        $wallets = $user->wallets()->orderBy('name')->get();
        $categories = $user->categories()->orderBy('name')->get();

        return view('transactions.create', compact(
            'wallets',
            'categories'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wallet_id' => ['required', 'integer'],
            'category_id' => ['required', 'integer'],
            'type' => [
                'required',
                Rule::in(['INCOME', 'EXPENSE']),
            ],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:9999999999999.99',
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'transaction_date' => ['required', 'date'],
        ]);

        $user = auth()->user();

        // Catatan saldo: operasi di atas menggunakan DB::transaction() dan lockForUpdate() supaya perubahan saldo dan data transaksi tersimpan atau dibatalkan bersama. Perhitungan menggunakan pembulatan dua desimal; untuk aplikasi keuangan dengan kebutuhan presisi tinggi, sebaiknya aritmetika uang menggunakan integer satuan terkecil atau pustaka desimal, bukan floating-point.

        DB::transaction(function () use ($validated, $user) {
            $wallet = Wallet::where('user_id', $user->id)
                ->whereKey($validated['wallet_id'])
                ->lockForUpdate()
                ->first();

            if (!$wallet) {
                throw ValidationException::withMessages([
                    'wallet_id' => 'Wallet tidak ditemukan.',
                ]);
            }

            $category = Category::where('user_id', $user->id)
                ->whereKey($validated['category_id'])
                ->first();

            if (!$category) {
                throw ValidationException::withMessages([
                    'category_id' => 'Kategori tidak ditemukan.',
                ]);
            }

            if ($category->type !== $validated['type']) {
                throw ValidationException::withMessages([
                    'category_id' => 'Tipe kategori harus sesuai dengan tipe transaksi.',
                ]);
            }

            $amount = round((float) $validated['amount'], 2);
            $balance = round((float) $wallet->balance, 2);

            if (
                $validated['type'] === 'EXPENSE'
                && $balance < $amount
            ) {
                throw ValidationException::withMessages([
                    'amount' => 'Saldo wallet tidak mencukupi.',
                ]);
            }

            $wallet->balance = round(
                $balance + (
                    $validated['type'] === 'INCOME'
                        ? $amount
                        : -$amount
                ),
                2
            );

            $wallet->save();

            $user->transactions()->create($validated);
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaction $transaction)
    {
        $transaction = auth()->user()
            ->transactions()
            ->with(['wallet', 'category'])
            ->findOrFail($transaction->id);

        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $user = auth()->user();

        $transaction = $user->transactions()
            ->findOrFail($transaction->id);

        $wallets = $user->wallets()->orderBy('name')->get();
        $categories = $user->categories()->orderBy('name')->get();

        return view('transactions.edit', compact(
            'transaction',
            'wallets',
            'categories'
        ));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $user = auth()->user();

        $transaction = $user->transactions()
            ->findOrFail($transaction->id);

        $validated = $request->validate([
            'wallet_id' => ['required', 'integer'],
            'category_id' => ['required', 'integer'],
            'type' => [
                'required',
                Rule::in(['INCOME', 'EXPENSE']),
            ],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:9999999999999.99',
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'transaction_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use (
            $validated,
            $transaction,
            $user
        ) {
            // Lock kedua wallet dengan urutan ID konsisten.
            $walletIds = collect([
                $transaction->wallet_id,
                (int) $validated['wallet_id'],
            ])->unique()->sort()->values();

            $wallets = Wallet::where('user_id', $user->id)
                ->whereIn('id', $walletIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($wallets->count() !== $walletIds->count()) {
                throw ValidationException::withMessages([
                    'wallet_id' => 'Wallet tidak ditemukan.',
                ]);
            }

            $category = Category::where('user_id', $user->id)
                ->whereKey($validated['category_id'])
                ->first();

            if (!$category) {
                throw ValidationException::withMessages([
                    'category_id' => 'Kategori tidak ditemukan.',
                ]);
            }

            if ($category->type !== $validated['type']) {
                throw ValidationException::withMessages([
                    'category_id' => 'Tipe kategori harus sesuai dengan tipe transaksi.',
                ]);
            }

            $oldWallet = $wallets->get($transaction->wallet_id);
            $newWallet = $wallets->get((int) $validated['wallet_id']);

            $oldAmount = round((float) $transaction->amount, 2);
            $newAmount = round((float) $validated['amount'], 2);

            // Batalkan dampak transaksi lama.
            $oldBalance = round((float) $oldWallet->balance, 2);

            $oldWallet->balance = round(
                $oldBalance + (
                    $transaction->type === 'INCOME'
                        ? -$oldAmount
                        : $oldAmount
                ),
                2
            );

            // Terapkan transaksi baru.
            $newBalance = round((float) $newWallet->balance, 2);

            if (
                $validated['type'] === 'EXPENSE'
                && $newBalance < $newAmount
            ) {
                throw ValidationException::withMessages([
                    'amount' => 'Saldo wallet tidak mencukupi untuk transaksi ini.',
                ]);
            }

            $newWallet->balance = round(
                $newBalance + (
                    $validated['type'] === 'INCOME'
                        ? $newAmount
                        : -$newAmount
                ),
                2
            );

            foreach ($wallets as $wallet) {
                $wallet->save();
            }

            $transaction->update($validated);
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $user = auth()->user();

        $transaction = $user->transactions()
            ->findOrFail($transaction->id);

        DB::transaction(function () use ($transaction, $user) {
            $wallet = Wallet::where('user_id', $user->id)
                ->whereKey($transaction->wallet_id)
                ->lockForUpdate()
                ->firstOrFail();

            $amount = round((float) $transaction->amount, 2);
            $balance = round((float) $wallet->balance, 2);

            // Batalkan dampak transaksi yang dihapus.
            $wallet->balance = round(
                $balance + (
                    $transaction->type === 'INCOME'
                        ? -$amount
                        : $amount
                ),
                2
            );

            $wallet->save();
            $transaction->delete();
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
