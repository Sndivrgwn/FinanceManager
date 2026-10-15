@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <x-page-header title="Tambah Kategori">
        <x-button :href="route('categories.index')" variant="secondary">Kembali</x-button>
    </x-page-header>

    <x-form-errors />

    @include('categories._form', ['category' => null])
@endsection