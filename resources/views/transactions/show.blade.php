
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
</head>
<body>
    <h1>Detail Transaksi</h1>

    <p>
        <strong>Tipe:</strong>
        {{ $transaction->type === 'INCOME' ? 'Pemasukan' : 'Pengeluaran' }}
    </p>

    <p>
        <strong>Nominal:</strong>
        {{ $transaction->type === 'INCOME' ? '+' : '-' }}
        Rp{{ number_format((float) $transaction->amount, 2, ',', '.') }}
    </p>

    <p><strong>Wallet:</strong> {{ $transaction->wallet->name }}</p>
    <p><strong>Kategori:</strong> {{ $transaction->category->name }}</p>

    <p>
        <strong>Tanggal:</strong>
        {{ $transaction->transaction_date->format('d-m-Y') }}
    </p>

    <p>
        <strong>Deskripsi:</strong>
        {{ $transaction->description ?? '-' }}
    </p>

    <a href="{{ route('transactions.index') }}">Kembali</a>
    <a href="{{ route('transactions.edit', $transaction) }}">Edit</a>
</body>
</html>
