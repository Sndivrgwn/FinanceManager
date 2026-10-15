@extends('layouts.app')

@section('title', 'Edit Wallet')

@section('content')
    <x-page-header title="Edit Wallet">
        <x-button :href="route('wallets.index')" variant="secondary">Kembali</x-button>
    </x-page-header>

    <x-form-errors />

    @include('wallets._form')
@endsection