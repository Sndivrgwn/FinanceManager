@extends('layouts.app')

@section('title', 'Tambah Transfer')

@section('content')
    <x-page-header title="Tambah Transfer">
        <x-button :href="route('transfers.index')" variant="secondary">Kembali</x-button>
    </x-page-header>

    <x-form-errors />

    @include('transfers._form', ['transfer' => null])
@endsection