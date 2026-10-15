@extends('layouts.app')

@section('title', 'Edit Transfer')

@section('content')
    <x-page-header title="Edit Transfer">
        <x-button :href="route('transfers.index')" variant="secondary">Kembali</x-button>
    </x-page-header>

    <x-form-errors />

    @include('transfers._form')
@endsection