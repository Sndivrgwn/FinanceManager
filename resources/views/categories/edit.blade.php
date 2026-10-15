
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
</head>
<body>
    <h1>Edit Kategori</h1>

    <a href="{{ route('categories.index') }}">Kembali</a>

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Kategori</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
                required
            >
        </div>

        <div>
            <label for="type">Tipe Kategori</label>
            <select id="type" name="type" required>
                <option value="INCOME"
                    @selected(old('type', $category->type) === 'INCOME')>
                    Pemasukan
                </option>

                <option value="EXPENSE"
                    @selected(old('type', $category->type) === 'EXPENSE')>
                    Pengeluaran
                </option>
            </select>
        </div>

        <button type="submit">Update Kategori</button>
    </form>
</body>
</html>
