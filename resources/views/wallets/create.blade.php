
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Wallet</title>
</head>
<body>
    <h1>Tambah Wallet</h1>

    <a href="{{ route('wallets.index') }}">Kembali</a>

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('wallets.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nama Wallet</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Contoh: BCA"
                required
            >
        </div>

        <div>
            <label for="type">Jenis Wallet</label>
            <select id="type" name="type" required>
                <option value="">Pilih jenis</option>
                <option value="CASH" @selected(old('type') === 'CASH')>
                    Cash
                </option>
                <option value="BANK" @selected(old('type') === 'BANK')>
                    Bank
                </option>
                <option value="E_WALLET" @selected(old('type') === 'E_WALLET')>
                    E-Wallet
                </option>
            </select>
        </div>

        <div>
            <label for="balance">Saldo Awal (Rp)</label>
            <input
                type="number"
                id="balance"
                name="balance"
                value="{{ old('balance', 0) }}"
                min="0"
                step="0.01"
                required
            >
        </div>

        <button type="submit">Simpan Wallet</button>
    </form>
</body>
</html>
