
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
</head>
<body>
    <h1>Tambah Transaksi</h1>

    <a href="{{ route('transactions.index') }}">Kembali</a>

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if ($wallets->isEmpty())
        <p>Kamu perlu membuat wallet terlebih dahulu.</p>
    @endif

    @if ($categories->isEmpty())
        <p>Kamu perlu membuat kategori terlebih dahulu.</p>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div>
            <label for="type">Tipe Transaksi</label>
            <select id="type" name="type" required>
                <option value="">Pilih tipe</option>
                <option value="INCOME" @selected(old('type') === 'INCOME')>
                    Pemasukan
                </option>
                <option value="EXPENSE" @selected(old('type') === 'EXPENSE')>
                    Pengeluaran
                </option>
            </select>
        </div>

        <div>
            <label for="wallet_id">Wallet</label>
            <select id="wallet_id" name="wallet_id" required>
                <option value="">Pilih wallet</option>

                @foreach ($wallets as $wallet)
                    <option
                        value="{{ $wallet->id }}"
                        @selected((string) old('wallet_id') === (string) $wallet->id)
                    >
                        {{ $wallet->name }}
                        (Rp{{ number_format((float) $wallet->balance, 2, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="category_id">Kategori</label>
            <select id="category_id" name="category_id" required>
                <option value="">Pilih kategori</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        data-type="{{ $category->type }}"
                        @selected((string) old('category_id') === (string) $category->id)
                    >
                        {{ $category->name }}
                        ({{ $category->type === 'INCOME' ? 'Pemasukan' : 'Pengeluaran' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="amount">Nominal (Rp)</label>
            <input
                type="number"
                id="amount"
                name="amount"
                value="{{ old('amount') }}"
                min="0.01"
                step="0.01"
                required
            >
        </div>

        <div>
            <label for="transaction_date">Tanggal Transaksi</label>
            <input
                type="date"
                id="transaction_date"
                name="transaction_date"
                value="{{ old('transaction_date', now()->toDateString()) }}"
                required
            >
        </div>

        <div>
            <label for="description">Deskripsi</label>
            <textarea
                id="description"
                name="description"
                maxlength="5000"
            >{{ old('description') }}</textarea>
        </div>

        <button
            type="submit"
            @disabled($wallets->isEmpty() || $categories->isEmpty())
        >
            Simpan Transaksi
        </button>
    </form>

    <script>
        const typeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category_id');

        function filterCategories() {
            const type = typeSelect.value;

            for (const option of categorySelect.options) {
                if (!option.value) {
                    option.hidden = false;
                    continue;
                }

                option.hidden = type !== '' && option.dataset.type !== type;
            }

            const selected = categorySelect.selectedOptions[0];

            if (selected && selected.hidden) {
                categorySelect.value = '';
            }
        }

        typeSelect.addEventListener('change', filterCategories);
        filterCategories();
    </script>
</body>
</html>
