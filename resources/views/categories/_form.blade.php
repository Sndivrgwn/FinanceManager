<x-card class="max-w-xl p-6">
    <form action="{{ $category ? route('categories.update', $category) : route('categories.store') }}"
          method="POST" class="space-y-5">
        @csrf
        @if ($category)
            @method('PUT')
        @endif

        <x-field name="name" label="Nama Kategori">
            <x-input name="name" :value="old('name', $category?->name)" maxlength="255"
                placeholder="Contoh: Gaji, Makan, Transport" required />
        </x-field>

        <x-field name="type" label="Tipe">
            <x-select name="type" required>
                <option value="">Pilih tipe</option>
                <option value="INCOME" @selected(old('type', $category?->type) === 'INCOME')>Pemasukan</option>
                <option value="EXPENSE" @selected(old('type', $category?->type) === 'EXPENSE')>Pengeluaran</option>
            </x-select>
        </x-field>

        <div class="flex gap-2 pt-2">
            <x-button type="submit">{{ $category ? 'Update Kategori' : 'Simpan Kategori' }}</x-button>
            <x-button :href="route('categories.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-card>