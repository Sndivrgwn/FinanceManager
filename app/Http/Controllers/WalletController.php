<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = auth()->user()
            ->wallets()
            ->latest()
            ->paginate(10);

        return view('wallets.index', compact('wallets'));
    }

    public function create()
    {
        return view('wallets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => [
                'required',
                Rule::in(['CASH', 'BANK', 'E_WALLET']),
            ],
            'balance' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
        ]);

        auth()->user()->wallets()->create($validated);

        return redirect()
            ->route('wallets.index')
            ->with('success', 'Wallet berhasil ditambahkan.');
    }

    public function show(Wallet $wallet)
    {
        $wallet = auth()->user()
            ->wallets()
            ->findOrFail($wallet->id);

        return view('wallets.show', compact('wallet'));
    }

    public function edit(Wallet $wallet)
    {
        $wallet = auth()->user()
            ->wallets()
            ->findOrFail($wallet->id);

        return view('wallets.edit', compact('wallet'));
    }

    public function update(Request $request, Wallet $wallet)
    {
        $wallet = auth()->user()
            ->wallets()
            ->findOrFail($wallet->id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => [
                'required',
                Rule::in(['CASH', 'BANK', 'E_WALLET']),
            ],
            'balance' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
        ]);

        $wallet->update($validated);

        return redirect()
            ->route('wallets.index')
            ->with('success', 'Wallet berhasil diperbarui.');
    }

    public function destroy(Wallet $wallet)
    {
        $wallet = auth()->user()
            ->wallets()
            ->findOrFail($wallet->id);

        try {
            $wallet->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('wallets.index')
                ->with(
                    'error',
                    'Wallet tidak bisa dihapus karena masih memiliki riwayat transaksi atau transfer.'
                );
        }

        return redirect()
            ->route('wallets.index')
            ->with('success', 'Wallet berhasil dihapus.');
    }
}
