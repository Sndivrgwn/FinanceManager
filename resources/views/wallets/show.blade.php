@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Detail Wallet')

@section('content')
    <x-page-header title="Detail Wallet">
        <x-button :href="route('wallets.index')" variant="secondary">Kembali</x-button>
        <x-button :href="route('wallets.edit', $wallet)">Edit</x-button>
        <x-delete-form :action="route('wallets.destroy', $wallet)"
            message="Yakin ingin menghapus wallet ini?" size="md" />
    </x-page-header>

    <x-card class="max-w-2xl">
        <dl class="divide-y divide-slate-100">
            <x-detail label="Nama">{{ $wallet->name }}</x-detail>
            <x-detail label="Tipe">
                <x-badge :color="Format::walletTypeColor($wallet->type)">
                    {{ Format::walletType($wallet->type) }}
                </x-badge>
            </x-detail>
            <x-detail label="Saldo">
                <span class="text-lg font-bold">{{ Format::rupiah($wallet->balance) }}</span>
            </x-detail>
            <x-detail label="Dibuat">{{ Format::date($wallet->created_at) }}</x-detail>
        </dl>
    </x-card>
@endsection