<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated["name"],
            'email' => $validated["email"],
            'password' => $validated["password"],
        ]);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard')->with('success', 'Welcome!');
    }
}
