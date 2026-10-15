@extends('layouts.guest')

@section('title', 'Daftar')
@section('heading', 'Buat akun baru')
@section('subheading', 'Mulai kelola keuanganmu dalam beberapa menit.')

@section('content')
    <form method="POST" action="/register" class="space-y-5">
        @csrf

        <x-auth-input name="name" label="Nama lengkap" icon="user"
            placeholder="Nama kamu" autocomplete="name" autofocus required />

        <x-auth-input name="email" type="email" label="Alamat email" icon="mail"
            placeholder="nama@contoh.com" autocomplete="email" required />

        <x-auth-input name="password" type="password" label="Password" icon="lock"
            placeholder="Buat password" autocomplete="new-password" required />

        <x-auth-input name="password_confirmation" type="password" label="Konfirmasi password" icon="lock"
            placeholder="Ulangi password" autocomplete="new-password" required />

        <x-auth-button>Buat Akun</x-auth-button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="/login" class="font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">Masuk</a>
    </p>
@endsection