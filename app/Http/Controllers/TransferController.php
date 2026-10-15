<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Wallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TransferController extends Controller
{
    public function index(): View
    {
        $transfers = auth()->user()
            ->transfers()
            ->with(['fromWallet', 'toWallet'])
            ->latest('transfer_date')
            ->latest('id')
            ->paginate(10);

        return view('transfers.index', compact('transfers'));
    }

    public function create(): View
    {
        $wallets = auth()->user()
            ->wallets()
            ->orderBy('name')
            ->get();

        return view('transfers.create', compact('wallets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $this->validateTransfer($request);

        if (
            $validated['from_wallet_id']
            === $validated['to_wallet_id']
        ) {
            throw ValidationException::withMessages([
                'to_wallet_id' => 'Wallet asal dan tujuan harus berbeda.',
            ]);
        }

        DB::transaction(function () use ($user, $validated) {
            $wallets = $this->lockWallets(
                $user->id,
                [
                    $validated['from_wallet_id'],
                    $validated['to_wallet_id'],
                ]
            );

            $fromWallet = $wallets->get(
                $validated['from_wallet_id']
            );

            $toWallet = $wallets->get(
                $validated['to_wallet_id']
            );

            if (!$fromWallet || !$toWallet) {
                throw ValidationException::withMessages([
                    'from_wallet_id' =>
                        'Wallet asal atau tujuan tidak valid.',
                ]);
            }

            $amount = (float) $validated['amount'];

            if ((float) $fromWallet->balance < $amount) {
                throw ValidationException::withMessages([
                    'amount' => 'Saldo wallet asal tidak mencukupi.',
                ]);
            }

            $fromWallet->balance = round(
                (float) $fromWallet->balance - $amount,
                2
            );

            $toWallet->balance = round(
                (float) $toWallet->balance + $amount,
                2
            );

            $fromWallet->save();
            $toWallet->save();

            $user->transfers()->create($validated);
        });

        return redirect()
            ->route('transfers.index')
            ->with('success', 'Transfer berhasil ditambahkan.');
    }

    public function show(Transfer $transfer): View
    {
        $transfer = auth()->user()
            ->transfers()
            ->with(['fromWallet', 'toWallet'])
            ->whereKey($transfer->id)
            ->firstOrFail();

        return view('transfers.show', compact('transfer'));
    }

    public function edit(Transfer $transfer): View
    {
        $transfer = auth()->user()
            ->transfers()
            ->whereKey($transfer->id)
            ->firstOrFail();

        $wallets = auth()->user()
            ->wallets()
            ->orderBy('name')
            ->get();

        return view(
            'transfers.edit',
            compact('transfer', 'wallets')
        );
    }

    public function update(
        Request $request,
        Transfer $transfer
    ): RedirectResponse {
        $user = $request->user();

        // Pastikan transfer ini milik pengguna yang sedang login.
        $transfer = $user->transfers()
            ->whereKey($transfer->id)
            ->firstOrFail();

        $validated = $this->validateTransfer($request);

        if (
            $validated['from_wallet_id']
            === $validated['to_wallet_id']
        ) {
            throw ValidationException::withMessages([
                'to_wallet_id' => 'Wallet asal dan tujuan harus berbeda.',
            ]);
        }

        DB::transaction(function () use (
            $user,
            $transfer,
            $validated
        ) {
            // Kunci seluruh wallet yang terlibat, termasuk
            // wallet asal dan tujuan transfer sebelumnya.
            $walletIds = [
                $transfer->from_wallet_id,
                $transfer->to_wallet_id,
                $validated['from_wallet_id'],
                $validated['to_wallet_id'],
            ];

            $wallets = $this->lockWallets(
                $user->id,
                $walletIds
            );

            $oldFrom = $wallets->get(
                $transfer->from_wallet_id
            );

            $oldTo = $wallets->get(
                $transfer->to_wallet_id
            );

            $newFrom = $wallets->get(
                $validated['from_wallet_id']
            );

            $newTo = $wallets->get(
                $validated['to_wallet_id']
            );

            if (!$oldFrom || !$oldTo || !$newFrom || !$newTo) {
                throw ValidationException::withMessages([
                    'from_wallet_id' =>
                        'Wallet asal atau tujuan tidak valid.',
                ]);
            }

            // Batalkan dampak transfer lama terlebih dahulu.
            $oldAmount = (float) $transfer->amount;

            $oldFrom->balance = round(
                (float) $oldFrom->balance + $oldAmount,
                2
            );

            $oldTo->balance = round(
                (float) $oldTo->balance - $oldAmount,
                2
            );

            $newAmount = (float) $validated['amount'];

            // Periksa saldo setelah dampak transfer lama dibatalkan.
            if ((float) $newFrom->balance < $newAmount) {
                throw ValidationException::withMessages([
                    'amount' =>
                        'Saldo wallet asal tidak mencukupi untuk transfer ini.',
                ]);
            }

            // Terapkan transfer yang baru.
            $newFrom->balance = round(
                (float) $newFrom->balance - $newAmount,
                2
            );

            $newTo->balance = round(
                (float) $newTo->balance + $newAmount,
                2
            );

            // Simpan setiap wallet satu kali.
            foreach ($wallets as $wallet) {
                $wallet->save();
            }

            $transfer->update($validated);
        });

        return redirect()
            ->route('transfers.index')
            ->with('success', 'Transfer berhasil diperbarui.');
    }

    public function destroy(Transfer $transfer): RedirectResponse
    {
        $user = request()->user();

        $transfer = $user->transfers()
            ->whereKey($transfer->id)
            ->firstOrFail();

        DB::transaction(function () use ($user, $transfer) {
            $wallets = $this->lockWallets(
                $user->id,
                [
                    $transfer->from_wallet_id,
                    $transfer->to_wallet_id,
                ]
            );

            $fromWallet = $wallets->get(
                $transfer->from_wallet_id
            );

            $toWallet = $wallets->get(
                $transfer->to_wallet_id
            );

            if (!$fromWallet || !$toWallet) {
                throw ValidationException::withMessages([
                    'transfer' =>
                        'Wallet yang terkait dengan transfer tidak ditemukan.',
                ]);
            }

            $amount = (float) $transfer->amount;

            // Kembalikan saldo seperti sebelum transfer.
            $fromWallet->balance = round(
                (float) $fromWallet->balance + $amount,
                2
            );

            $toWallet->balance = round(
                (float) $toWallet->balance - $amount,
                2
            );

            $fromWallet->save();
            $toWallet->save();

            $transfer->delete();
        });

        return redirect()
            ->route('transfers.index')
            ->with('success', 'Transfer berhasil dihapus.');
    }

    private function validateTransfer(Request $request): array
    {
        return $request->validate([
            'from_wallet_id' => [
                'required',
                'integer',
                'different:to_wallet_id',
            ],
            'to_wallet_id' => [
                'required',
                'integer',
            ],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:9999999999999.99',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'transfer_date' => [
                'required',
                'date',
            ],
        ]);
    }

    /**
     * Ambil dan kunci wallet milik user dengan urutan ID konsisten
     * untuk mengurangi risiko deadlock.
     */
    private function lockWallets(int $userId, array $walletIds)
    {
        $ids = array_values(array_unique(
            array_map('intval', $walletIds)
        ));

        sort($ids);

        return Wallet::query()
            ->where('user_id', $userId)
            ->whereIn('id', $ids)
            ->orderBy('id')
            ->lockForUpdate()
            ->get()
            ->keyBy('id');
    }
}
