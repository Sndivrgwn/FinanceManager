
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wallet</title>
</head>
<body>
    <h1>Edit Wallet</h1>

    <a href="{{ route('wallets.index') }}">Kembali</a>

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('wallets.update', $wallet) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Wallet</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $wallet->name) }}"
                required
            >
        </div>

        <div>
            <label for="type">Jenis Wallet</label>
            <select id="type" name="type" required>
                <option value="CASH"
                    @selected(old('type', $wallet->type) === 'CASH')>
                    Cash
                </option>

                <option value="BANK"
                    @selected(old('type', $wallet->type) === 'BANK')>
                    Bank
                </option>

                <option value="E_WALLET"
                    @selected(old('type', $wallet->type) === 'E_WALLET')>
                    E-Wallet
                </option>
            </select>
        </div>

        <div>
            <label for="balance">Saldo (Rp)</label>
            <input
                type="number"
                id="balance"
                name="balance"
                value="{{ old('balance', $wallet->balance) }}"
                min="0"
                step="0.01"
                required
            >
        </div>

        <button type="submit">Update Wallet</button>
    </form>
</body>
</html>
