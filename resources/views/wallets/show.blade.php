
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Wallet</title>
</head>
<body>
    <h1>Detail Wallet</h1>

    <p><strong>Nama:</strong> {{ $wallet->name }}</p>

    <p>
        <strong>Jenis:</strong>
        {{ str_replace('_', ' ', $wallet->type) }}
    </p>

    <p>
        <strong>Saldo:</strong>
        Rp{{ number_format((float) $wallet->balance, 2, ',', '.') }}
    </p>

    <p>
        <strong>Dibuat:</strong>
        {{ $wallet->created_at->format('d-m-Y H:i') }}
    </p>

    <a href="{{ route('wallets.index') }}">Kembali</a>
    <a href="{{ route('wallets.edit', $wallet) }}">Edit Wallet</a>
</body>
</html>
