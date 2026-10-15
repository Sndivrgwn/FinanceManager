@extends('layouts.app')

@section('title', 'Tambah Wallet')

@section('content')
    <x-page-header title="Tambah Wallet">
        <x-button :href="route('wallets.index')" variant="secondary">Kembali</x-button>
    </x-page-header>

    <x-form-errors />

    @include('wallets._form', ['wallet' => null])
@endsection