<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()
            ->categories()
            ->latest()
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where('user_id', auth()->id())
                    ->where('type', $request->input('type')),
            ],
            'type' => [
                'required',
                Rule::in(['INCOME', 'EXPENSE']),
            ],
        ]);

        auth()->user()->categories()->create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        $category = auth()->user()
            ->categories()
            ->findOrFail($category->id);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $category = auth()->user()
            ->categories()
            ->findOrFail($category->id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category = auth()->user()
            ->categories()
            ->findOrFail($category->id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where('user_id', auth()->id())
                    ->where('type', $request->input('type'))
                    ->ignore($category->id),
            ],
            'type' => [
                'required',
                Rule::in(['INCOME', 'EXPENSE']),
            ],
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category = auth()->user()
            ->categories()
            ->findOrFail($category->id);

        try {
            $category->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena masih digunakan oleh transaksi.'
                );
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
