<div class="container">
    <div class="mb-4">
        <h1 class="h3">Tambah Transfer</h1>
        <p class="text-muted">
            Pindahkan saldo dari satu wallet ke wallet lainnya.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($wallets->count() < 2)
        <div class="alert alert-warning">
            Kamu membutuhkan minimal dua wallet untuk melakukan transfer.
            <a href="{{ route('wallets.create') }}">Tambah wallet</a>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('transfers.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="from_wallet_id" class="form-label">
                        Wallet Asal
                    </label>

                    <select name="from_wallet_id"
                            id="from_wallet_id"
                            class="form-select"
                            required>
                        <option value="">Pilih wallet asal</option>

                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}"
                                @selected(old('from_wallet_id') == $wallet->id)>
                                {{ $wallet->name }}
                                — Saldo Rp{{ number_format((float) $wallet->balance, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>

                    @error('from_wallet_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="to_wallet_id" class="form-label">
                        Wallet Tujuan
                    </label>

                    <select name="to_wallet_id"
                            id="to_wallet_id"
                            class="form-select"
                            required>
                        <option value="">Pilih wallet tujuan</option>

                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}"
                                @selected(old('to_wallet_id') == $wallet->id)>
                                {{ $wallet->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('to_wallet_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">
                        Jumlah Transfer
                    </label>

                    <input type="number"
                           name="amount"
                           id="amount"
                           class="form-control"
                           min="0.01"
                           step="0.01"
                           max="9999999999999.99"
                           value="{{ old('amount') }}"
                           placeholder="Contoh: 200000"
                           required>

                    @error('amount')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="transfer_date" class="form-label">
                        Tanggal Transfer
                    </label>

                    <input type="date"
                           name="transfer_date"
                           id="transfer_date"
                           class="form-control"
                           value="{{ old('transfer_date', now()->toDateString()) }}"
                           required>

                    @error('transfer_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        Keterangan (Opsional)
                    </label>

                    <textarea name="description"
                              id="description"
                              class="form-control"
                              rows="3"
                              maxlength="5000"
                              placeholder="Contoh: Isi saldo DANA">{{ old('description') }}</textarea>

                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit"
                            class="btn btn-primary"
                            @disabled($wallets->count() < 2)>
                        Simpan Transfer
                    </button>

                    <a href="{{ route('transfers.index') }}"
                       class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fromWallet = document.getElementById('from_wallet_id');
        const toWallet = document.getElementById('to_wallet_id');

        function updateWalletOptions() {
            const fromId = fromWallet.value;

            Array.from(toWallet.options).forEach(function (option) {
                if (!option.value) {
                    option.disabled = false;
                    return;
                }

                option.disabled = option.value === fromId;
            });

            if (toWallet.value === fromId) {
                toWallet.value = '';
            }
        }

        fromWallet.addEventListener('change', updateWalletOptions);
        updateWalletOptions();
    });
</script>