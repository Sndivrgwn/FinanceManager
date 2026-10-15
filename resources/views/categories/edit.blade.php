@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <x-page-header title="Edit Kategori">
        <x-button :href="route('categories.index')" variant="secondary">Kembali</x-button>
    </x-page-header>

    <x-form-errors />

    @include('categories._form')
@endsection