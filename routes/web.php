<?php

use App\Http\Controllers\Auth\LoginControlller;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/logout', LogoutController::class)->middleware('auth')->name('logout');
});

Route::view('/login', 'auth.login')->name("login");
Route::view('/register', 'auth.register')->name("register");
Route::post('/login', LoginControlller::class);
Route::post('/register', RegisterController::class);