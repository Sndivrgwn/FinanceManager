
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
</head>
<body>
    <h1>My Categories</h1>

    <a href="{{ route('categories.create') }}">+ Tambah Kategori</a>

    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    @forelse ($categories as $category)
        <hr>

        <h3>{{ $category->name }}</h3>

        <p>
            Tipe:
            {{ $category->type === 'INCOME' ? 'Pemasukan' : 'Pengeluaran' }}
        </p>

        <a href="{{ route('categories.show', $category) }}">Detail</a>
        |
        <a href="{{ route('categories.edit', $category) }}">Edit</a>

        <form
            action="{{ route('categories.destroy', $category) }}"
            method="POST"
            style="display: inline"
            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
        >
            @csrf
            @method('DELETE')

            <button type="submit">Hapus</button>
        </form>
    @empty
        <p>Belum ada kategori.</p>
    @endforelse

    {{ $categories->links() }}
</body>
</html>
