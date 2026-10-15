@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
    <x-page-header title="Detail Kategori">
        <x-button :href="route('categories.index')" variant="secondary">Kembali</x-button>
        <x-button :href="route('categories.edit', $category)">Edit</x-button>
        <x-delete-form :action="route('categories.destroy', $category)"
            message="Yakin ingin menghapus kategori ini?" size="md" />
    </x-page-header>

    <x-card class="max-w-2xl">
        <dl class="divide-y divide-slate-100">
            <x-detail label="Nama">{{ $category->name }}</x-detail>
            <x-detail label="Tipe">
                <x-badge :color="Format::flowTypeColor($category->type)">
                    {{ Format::flowType($category->type) }}
                </x-badge>
            </x-detail>
            <x-detail label="Dibuat">{{ Format::date($category->created_at) }}</x-detail>
        </dl>
    </x-card>
@endsection