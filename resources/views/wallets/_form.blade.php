<x-card class="max-w-xl p-6">
    <form action="{{ $wallet ? route('wallets.update', $wallet) : route('wallets.store') }}"
          method="POST" class="space-y-5">
        @csrf
        @if ($wallet)
            @method('PUT')
        @endif

        <x-field name="name" label="Nama Wallet">
            <x-input name="name" :value="old('name', $wallet?->name)" maxlength="255"
                placeholder="Contoh: BCA, Dompet, GoPay" required />
        </x-field>

        <x-field name="type" label="Tipe">
            <x-select name="type" required>
                <option value="">Pilih tipe</option>
                @foreach (['CASH' => 'Tunai', 'BANK' => 'Bank', 'E_WALLET' => 'E-Wallet'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('type', $wallet?->type) === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </x-select>
        </x-field>

        <x-field name="balance"
            :label="$wallet ? 'Saldo (Rp)' : 'Saldo Awal (Rp)'"
            :hint="$wallet ? 'Saldo berubah otomatis oleh transaksi dan transfer. Ubah manual hanya untuk koreksi.' : null">
            <x-input type="number" name="balance" :value="old('balance', $wallet?->balance ?? 0)"
                min="0" step="0.01" required />
        </x-field>

        <div class="flex gap-2 pt-2">
            <x-button type="submit">{{ $wallet ? 'Update Wallet' : 'Simpan Wallet' }}</x-button>
            <x-button :href="route('wallets.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-card>