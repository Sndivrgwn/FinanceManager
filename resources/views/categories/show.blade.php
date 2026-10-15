
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
</head>
<body>
    <h1>Detail Kategori</h1>

    <p><strong>Nama:</strong> {{ $category->name }}</p>

    <p>
        <strong>Tipe:</strong>
        {{ $category->type === 'INCOME' ? 'Pemasukan' : 'Pengeluaran' }}
    </p>

    <p>
        <strong>Dibuat:</strong>
        {{ $category->created_at->format('d-m-Y H:i') }}
    </p>

    <a href="{{ route('categories.index') }}">Kembali</a>
    <a href="{{ route('categories.edit', $category) }}">Edit Kategori</a>
</body>
</html>
