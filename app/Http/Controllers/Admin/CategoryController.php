<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->withCount('products')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $mainCategories = Category::main()->get();
        return view('admin.categories.create', compact('mainCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:categories,id',
            'deskripsi' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori / Sub-kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $mainCategories = Category::main()->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'mainCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:categories,id',
            'deskripsi' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori / Sub-kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
