
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wallets</title>
</head>
<body>
    <h1>My Wallets</h1>

    <a href="{{ route('wallets.create') }}">+ Tambah Wallet</a>

    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    @forelse ($wallets as $wallet)
        <hr>

        <h3>{{ $wallet->name }}</h3>

        <p>
            Jenis:
            {{ str_replace('_', ' ', $wallet->type) }}
        </p>

        <p>
            Saldo:
            Rp{{ number_format((float) $wallet->balance, 2, ',', '.') }}
        </p>

        <a href="{{ route('wallets.show', $wallet) }}">Detail</a>
        |
        <a href="{{ route('wallets.edit', $wallet) }}">Edit</a>

        <form action="{{ route('wallets.destroy', $wallet) }}"
              method="POST"
              style="display: inline"
              onsubmit="return confirm('Yakin ingin menghapus wallet ini?')">
            @csrf
            @method('DELETE')

            <button type="submit">Hapus</button>
        </form>
    @empty
        <p>Belum ada wallet. Silakan tambahkan wallet pertama kamu.</p>
    @endforelse

    {{ $wallets->links() }}
</body>
</html>
