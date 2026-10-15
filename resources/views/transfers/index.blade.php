@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Transfer')

@section('content')
    <x-page-header title="Transfer" subtitle="Pindahkan uang antar wallet. Transfer tidak dihitung sebagai pemasukan atau pengeluaran.">
        <x-button :href="route('transfers.create')">+ Tambah Transfer</x-button>
    </x-page-header>

    <x-card>
        @if ($transfers->isEmpty())
            <x-empty-state message="Belum ada transfer.">
                <x-button :href="route('transfers.create')">Buat transfer pertama</x-button>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-xs uppercase text-slate-500">
                            <th class="px-5 py-3 font-medium">Tanggal</th>
                            <th class="px-5 py-3 font-medium">Dari &rarr; Ke</th>
                            <th class="px-5 py-3 text-right font-medium">Nominal</th>
                            <th class="px-5 py-3 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($transfers as $transfer)
                            <tr>
                                <td class="whitespace-nowrap px-5 py-3 text-slate-600">
                                    {{ Format::date($transfer->transfer_date) }}
                                </td>
                                <td class="px-5 py-3">
                                    <p class="font-medium text-slate-800">
                                        {{ $transfer->fromWallet?->name ?? '-' }}
                                        <span class="text-slate-400">&rarr;</span>
                                        {{ $transfer->toWallet?->name ?? '-' }}
                                    </p>
                                    @if ($transfer->description)
                                        <p class="max-w-xs truncate text-xs text-slate-400">{{ $transfer->description }}</p>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-slate-900">
                                    {{ Format::rupiah($transfer->amount) }}
                                </td>
                                <td class="px-5 py-3">
                                    <x-row-actions resource="transfers" :model="$transfer"
                                        message="Yakin ingin menghapus transfer ini?" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>

    <x-pagination :paginator="$transfers" />
@endsection