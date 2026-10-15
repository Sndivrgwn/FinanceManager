@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
    <x-page-header title="Tambah Transaksi">
        <x-button :href="route('transactions.index')" variant="secondary">Kembali</x-button>
    </x-page-header>

    <x-form-errors />

    @include('transactions._form', ['transaction' => null])
@endsection