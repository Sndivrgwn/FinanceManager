@extends('layouts.guest')

@section('title', 'Masuk')
@section('heading', 'Selamat datang kembali')
@section('subheading', 'Masuk untuk melanjutkan ke akunmu.')

@section('content')
    <form method="POST" action="/login" class="space-y-5">
        @csrf

        <x-auth-input name="email" type="email" label="Alamat email" icon="mail"
            placeholder="nama@contoh.com" autocomplete="email" autofocus required />

        <x-auth-input name="password" type="password" label="Password" icon="lock"
            placeholder="Masukkan password" autocomplete="current-password" required />

        <x-auth-button>Masuk</x-auth-button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">
        Belum punya akun?
        <a href="/register" class="font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">Daftar sekarang</a>
    </p>
@endsection