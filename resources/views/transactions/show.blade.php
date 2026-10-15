@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    @php $isIncome = $transaction->type === 'INCOME'; @endphp

    <x-page-header title="Detail Transaksi">
        <x-button :href="route('transactions.index')" variant="secondary">Kembali</x-button>
        <x-button :href="route('transactions.edit', $transaction)">Edit</x-button>
        <x-delete-form :action="route('transactions.destroy', $transaction)"
            message="Yakin ingin menghapus transaksi ini?" size="md" />
    </x-page-header>

    <x-card class="max-w-2xl">
        <dl class="divide-y divide-slate-100">
            <x-detail label="Tipe">
                <x-badge :color="Format::flowTypeColor($transaction->type)">
                    {{ Format::flowType($transaction->type) }}
                </x-badge>
            </x-detail>
            <x-detail label="Nominal">
                <span class="text-lg font-bold {{ $isIncome ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $isIncome ? '+' : '-' }}{{ Format::rupiah($transaction->amount) }}
                </span>
            </x-detail>
            <x-detail label="Wallet">{{ $transaction->wallet?->name ?? '-' }}</x-detail>
            <x-detail label="Kategori">{{ $transaction->category?->name ?? '-' }}</x-detail>
            <x-detail label="Tanggal">{{ Format::date($transaction->transaction_date) }}</x-detail>
            <x-detail label="Deskripsi">
                <span class="whitespace-pre-line">{{ $transaction->description ?: '-' }}</span>
            </x-detail>
        </dl>
    </x-card>
@endsection