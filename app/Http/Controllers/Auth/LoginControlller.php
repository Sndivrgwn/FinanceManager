<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginControlller extends Controller
{
    public function __invoke(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'Welcome Back!');
        }

        return back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->onlyInput('email');
    }
}
