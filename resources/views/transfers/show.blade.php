@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Detail Transfer')

@section('content')
    <x-page-header title="Detail Transfer">
        <x-button :href="route('transfers.index')" variant="secondary">Kembali</x-button>
        <x-button :href="route('transfers.edit', $transfer)">Edit</x-button>
        <x-delete-form :action="route('transfers.destroy', $transfer)"
            message="Yakin ingin menghapus transfer ini?" size="md" />
    </x-page-header>

    <x-card class="max-w-2xl">
        <dl class="divide-y divide-slate-100">
            <x-detail label="Dari Wallet">{{ $transfer->fromWallet?->name ?? '-' }}</x-detail>
            <x-detail label="Ke Wallet">{{ $transfer->toWallet?->name ?? '-' }}</x-detail>
            <x-detail label="Nominal">
                <span class="text-lg font-bold">{{ Format::rupiah($transfer->amount) }}</span>
            </x-detail>
            <x-detail label="Tanggal">{{ Format::date($transfer->transfer_date) }}</x-detail>
            <x-detail label="Deskripsi">
                <span class="whitespace-pre-line">{{ $transfer->description ?: '-' }}</span>
            </x-detail>
        </dl>
    </x-card>
@endsection