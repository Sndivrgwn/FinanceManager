@use('App\Support\Format')

@if ($wallets->count() < 2)
    <x-notice>
        Kamu membutuhkan minimal dua wallet untuk membuat transfer.
        <a href="{{ route('wallets.create') }}" class="font-medium underline">Buat wallet</a>
    </x-notice>
@endif

<x-card class="max-w-3xl p-6">
    <form action="{{ $transfer ? route('transfers.update', $transfer) : route('transfers.store') }}"
          method="POST" class="grid gap-5 sm:grid-cols-2">
        @csrf
        @if ($transfer)
            @method('PUT')
        @endif

        <x-field name="from_wallet_id" label="Dari Wallet">
            <x-select name="from_wallet_id" required>
                <option value="">Pilih wallet asal</option>
                @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}"
                        @selected((string) old('from_wallet_id', $transfer?->from_wallet_id) === (string) $wallet->id)>
                        {{ $wallet->name }} ({{ Format::rupiah($wallet->balance) }})
                    </option>
                @endforeach
            </x-select>
        </x-field>

        <x-field name="to_wallet_id" label="Ke Wallet">
            <x-select name="to_wallet_id" required>
                <option value="">Pilih wallet tujuan</option>
                @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}"
                        @selected((string) old('to_wallet_id', $transfer?->to_wallet_id) === (string) $wallet->id)>
                        {{ $wallet->name }} ({{ Format::rupiah($wallet->balance) }})
                    </option>
                @endforeach
            </x-select>
        </x-field>

        <x-field name="amount" label="Nominal (Rp)">
            <x-input type="number" name="amount" :value="old('amount', $transfer?->amount)"
                min="0.01" step="0.01" placeholder="0" required />
        </x-field>

        <x-field name="transfer_date" label="Tanggal Transfer">
            <x-input type="date" name="transfer_date" required
                :value="old('transfer_date', $transfer?->transfer_date->format('Y-m-d') ?? now()->toDateString())" />
        </x-field>

        <x-field name="description" label="Deskripsi (opsional)" class="sm:col-span-2">
            <x-textarea name="description" maxlength="5000">{{ old('description', $transfer?->description) }}</x-textarea>
        </x-field>

        <div class="flex gap-2 pt-2 sm:col-span-2">
            <x-button type="submit" :disabled="$wallets->count() < 2">
                {{ $transfer ? 'Update Transfer' : 'Simpan Transfer' }}
            </x-button>
            <x-button :href="route('transfers.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-card>

@push('scripts')
    <script>
        const fromSelect = document.getElementById('from_wallet_id');
        const toSelect = document.getElementById('to_wallet_id');

        // Cegah memilih wallet yang sama di kedua sisi (backend tetap memvalidasi).
        function syncWallets() {
            for (const option of toSelect.options) {
                option.disabled = option.value !== '' && option.value === fromSelect.value;
            }

            if (toSelect.selectedOptions[0]?.disabled) {
                toSelect.value = '';
            }

            for (const option of fromSelect.options) {
                option.disabled = option.value !== '' && option.value === toSelect.value;
            }
        }

        fromSelect.addEventListener('change', syncWallets);
        toSelect.addEventListener('change', syncWallets);
        syncWallets();
    </script>
@endpush