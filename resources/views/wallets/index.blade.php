@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Wallet')

@section('content')
    <x-page-header title="Wallet" subtitle="Kelola dompet, rekening bank, dan e-wallet kamu.">
        <x-button :href="route('wallets.create')">+ Tambah Wallet</x-button>
    </x-page-header>

    <x-card>
        @if ($wallets->isEmpty())
            <x-empty-state message="Belum ada wallet.">
                <x-button :href="route('wallets.create')">Buat wallet pertama</x-button>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-xs uppercase text-slate-500">
                            <th class="px-5 py-3 font-medium">Nama</th>
                            <th class="px-5 py-3 font-medium">Tipe</th>
                            <th class="px-5 py-3 text-right font-medium">Saldo</th>
                            <th class="px-5 py-3 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($wallets as $wallet)
                            <tr>
                                <td class="px-5 py-3 font-medium text-slate-800">{{ $wallet->name }}</td>
                                <td class="px-5 py-3">
                                    <x-badge :color="Format::walletTypeColor($wallet->type)">
                                        {{ Format::walletType($wallet->type) }}
                                    </x-badge>
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-slate-900">
                                    {{ Format::rupiah($wallet->balance) }}
                                </td>
                                <td class="px-5 py-3">
                                    <x-row-actions resource="wallets" :model="$wallet"
                                        message="Yakin ingin menghapus wallet ini?" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>

    <x-pagination :paginator="$wallets" />
@endsection