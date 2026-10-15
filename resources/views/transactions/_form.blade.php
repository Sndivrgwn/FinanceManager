@use('App\Support\Format')

@if ($wallets->isEmpty())
    <x-notice>
        Kamu perlu membuat wallet terlebih dahulu.
        <a href="{{ route('wallets.create') }}" class="font-medium underline">Buat wallet</a>
    </x-notice>
@endif

@if ($categories->isEmpty())
    <x-notice>
        Kamu perlu membuat kategori terlebih dahulu.
        <a href="{{ route('categories.create') }}" class="font-medium underline">Buat kategori</a>
    </x-notice>
@endif

<x-card class="max-w-3xl p-6">
    <form action="{{ $transaction ? route('transactions.update', $transaction) : route('transactions.store') }}"
          method="POST" class="grid gap-5 sm:grid-cols-2">
        @csrf
        @if ($transaction)
            @method('PUT')
        @endif

        <x-field name="type" label="Tipe Transaksi">
            <x-select name="type" required>
                <option value="">Pilih tipe</option>
                <option value="INCOME" @selected(old('type', $transaction?->type) === 'INCOME')>Pemasukan</option>
                <option value="EXPENSE" @selected(old('type', $transaction?->type) === 'EXPENSE')>Pengeluaran</option>
            </x-select>
        </x-field>

        <x-field name="transaction_date" label="Tanggal Transaksi">
            <x-input type="date" name="transaction_date" required
                :value="old('transaction_date', $transaction?->transaction_date->format('Y-m-d') ?? now()->toDateString())" />
        </x-field>

        <x-field name="wallet_id" label="Wallet">
            <x-select name="wallet_id" required>
                <option value="">Pilih wallet</option>
                @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}"
                        @selected((string) old('wallet_id', $transaction?->wallet_id) === (string) $wallet->id)>
                        {{ $wallet->name }} ({{ Format::rupiah($wallet->balance) }})
                    </option>
                @endforeach
            </x-select>
        </x-field>

        <x-field name="category_id" label="Kategori">
            <x-select name="category_id" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" data-type="{{ $category->type }}"
                        @selected((string) old('category_id', $transaction?->category_id) === (string) $category->id)>
                        {{ $category->name }} ({{ Format::flowType($category->type) }})
                    </option>
                @endforeach
            </x-select>
        </x-field>

        <x-field name="amount" label="Nominal (Rp)" class="sm:col-span-2">
            <x-input type="number" name="amount" :value="old('amount', $transaction?->amount)"
                min="0.01" step="0.01" placeholder="0" required />
        </x-field>

        <x-field name="description" label="Deskripsi (opsional)" class="sm:col-span-2">
            <x-textarea name="description" maxlength="5000">{{ old('description', $transaction?->description) }}</x-textarea>
        </x-field>

        <div class="flex gap-2 pt-2 sm:col-span-2">
            <x-button type="submit" :disabled="$wallets->isEmpty() || $categories->isEmpty()">
                {{ $transaction ? 'Update Transaksi' : 'Simpan Transaksi' }}
            </x-button>
            <x-button :href="route('transactions.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-card>

@push('scripts')
    <script>
        const typeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category_id');

        // Tampilkan hanya kategori yang tipenya sama dengan tipe transaksi.
        function filterCategories() {
            const type = typeSelect.value;

            for (const option of categorySelect.options) {
                if (!option.value) continue;

                const mismatch = type !== '' && option.dataset.type !== type;
                option.hidden = mismatch;
                option.disabled = mismatch; // hidden saja tidak cukup di sebagian browser mobile
            }

            if (categorySelect.selectedOptions[0]?.disabled) {
                categorySelect.value = '';
            }
        }

        typeSelect.addEventListener('change', filterCategories);
        filterCategories();
    </script>
@endpush