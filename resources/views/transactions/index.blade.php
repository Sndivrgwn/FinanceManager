
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
</head>
<body>
    <h1>Transactions</h1>

    <a href="{{ route('transactions.create') }}">+ Tambah Transaksi</a>

    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    @forelse ($transactions as $transaction)
        <hr>

        <h3>{{ $transaction->category->name }}</h3>

        <p>
            Tipe:
            {{ $transaction->type === 'INCOME' ? 'Pemasukan' : 'Pengeluaran' }}
        </p>

        <p>
            Nominal:
            {{ $transaction->type === 'INCOME' ? '+' : '-' }}
            Rp{{ number_format((float) $transaction->amount, 2, ',', '.') }}
        </p>

        <p>Wallet: {{ $transaction->wallet->name }}</p>

        <p>
            Tanggal:
            {{ $transaction->transaction_date->format('d-m-Y') }}
        </p>

        <p>Deskripsi: {{ $transaction->description ?? '-' }}</p>

        <a href="{{ route('transactions.show', $transaction) }}">Detail</a>
        |
        <a href="{{ route('transactions.edit', $transaction) }}">Edit</a>

        <form
            action="{{ route('transactions.destroy', $transaction) }}"
            method="POST"
            style="display: inline"
            onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
        >
            @csrf
            @method('DELETE')

            <button type="submit">Hapus</button>
        </form>
    @empty
        <p>Belum ada transaksi.</p>
    @endforelse

    {{ $transactions->links() }}
</body>
</html>
