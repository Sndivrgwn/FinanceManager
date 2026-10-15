@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
    <x-page-header title="Edit Transaksi">
        <x-button :href="route('transactions.index')" variant="secondary">Kembali</x-button>
    </x-page-header>

    <x-form-errors />

    @include('transactions._form')
@endsection