@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <x-page-header title="Kategori" subtitle="Kelompokkan pemasukan dan pengeluaran kamu.">
        <x-button :href="route('categories.create')">+ Tambah Kategori</x-button>
    </x-page-header>

    <x-card>
        @if ($categories->isEmpty())
            <x-empty-state message="Belum ada kategori.">
                <x-button :href="route('categories.create')">Buat kategori pertama</x-button>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-xs uppercase text-slate-500">
                            <th class="px-5 py-3 font-medium">Nama</th>
                            <th class="px-5 py-3 font-medium">Tipe</th>
                            <th class="px-5 py-3 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($categories as $category)
                            <tr>
                                <td class="px-5 py-3 font-medium text-slate-800">{{ $category->name }}</td>
                                <td class="px-5 py-3">
                                    <x-badge :color="Format::flowTypeColor($category->type)">
                                        {{ Format::flowType($category->type) }}
                                    </x-badge>
                                </td>
                                <td class="px-5 py-3">
                                    <x-row-actions resource="categories" :model="$category"
                                        message="Yakin ingin menghapus kategori ini?" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>

    <x-pagination :paginator="$categories" />
@endsection