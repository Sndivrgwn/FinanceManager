@use('App\Support\Format')
@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
    <x-page-header title="Transaksi" subtitle="Riwayat pemasukan dan pengeluaran kamu.">
        <x-button :href="route('transactions.create')">+ Tambah Transaksi</x-button>
    </x-page-header>

    <x-card>
        @if ($transactions->isEmpty())
            <x-empty-state message="Belum ada transaksi.">
                <x-button :href="route('transactions.create')">Tambah transaksi pertama</x-button>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-xs uppercase text-slate-500">
                            <th class="px-5 py-3 font-medium">Tanggal</th>
                            <th class="px-5 py-3 font-medium">Kategori</th>
                            <th class="px-5 py-3 font-medium">Wallet</th>
                            <th class="px-5 py-3 font-medium">Tipe</th>
                            <th class="px-5 py-3 text-right font-medium">Nominal</th>
                            <th class="px-5 py-3 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($transactions as $transaction)
                            @php $isIncome = $transaction->type === 'INCOME'; @endphp
                            <tr>
                                <td class="whitespace-nowrap px-5 py-3 text-slate-600">
                                    {{ Format::date($transaction->transaction_date) }}
                                </td>
                                <td class="px-5 py-3">
                                    <p class="font-medium text-slate-800">{{ $transaction->category?->name ?? '-' }}</p>
                                    @if ($transaction->description)
                                        <p class="max-w-xs truncate text-xs text-slate-400">{{ $transaction->description }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $transaction->wallet?->name ?? '-' }}</td>
                                <td class="px-5 py-3">
                                    <x-badge :color="Format::flowTypeColor($transaction->type)">
                                        {{ Format::flowType($transaction->type) }}
                                    </x-badge>
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-right font-semibold {{ $isIncome ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ $isIncome ? '+' : '-' }}{{ Format::rupiah($transaction->amount) }}
                                </td>
                                <td class="px-5 py-3">
                                    <x-row-actions resource="transactions" :model="$transaction"
                                        message="Yakin ingin menghapus transaksi ini?" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>

    <x-pagination :paginator="$transactions" />
@endsection