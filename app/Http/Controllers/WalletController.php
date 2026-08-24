<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index() {
        $wallet = Wallet::select(['name', 'type', 'balance'])->get();

        return $wallet;
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:BANK,CASH,E_WALLET',
            'balance' => 'required|min:0|numeric'
        ]);

        if(!$validated) {

        }

        Wallet::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'balance' => $validated['balance'],
        ]);

        return redirect()->intended('/dashboard')->with('success', 'Wallet Added!');
    }
}
