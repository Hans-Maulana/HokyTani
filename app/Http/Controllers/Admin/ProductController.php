<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Problem;
use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['categories.parent', 'problems', 'rack'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $mainCategories = Category::main()->with('children')->get();
        $problems = Problem::all();
        $racks = Rack::all();
        $gridCells = \App\Models\StoreGrid::orderBy('row_idx')->orderBy('col_idx')->get();
        return view('admin.products.create', compact('mainCategories', 'problems', 'racks', 'gridCells'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
            'nama' => 'required|string|max:100',
            'merk' => 'nullable|string|max:100',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'bahan_aktif' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rack_id' => 'nullable|exists:racks,id',
            'lokasi_rak' => 'nullable|string|max:100',
            'categories' => 'array',
            'problems' => 'array',
        ]);

        // Auto generate barcode if left empty
        if (empty($validated['barcode'])) {
            do {
                $autoBarcode = 'HKT-' . rand(100000, 999999);
            } while (Product::where('barcode', $autoBarcode)->exists());
            $validated['barcode'] = $autoBarcode;
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('products', 'public');
        }

        $product = Product::create($validated);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->has('problems')) {
            $product->problems()->sync($request->problems);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $mainCategories = Category::main()->with('children')->get();
        $problems = Problem::all();
        $racks = Rack::all();
        $gridCells = \App\Models\StoreGrid::orderBy('row_idx')->orderBy('col_idx')->get();
        return view('admin.products.edit', compact('product', 'mainCategories', 'problems', 'racks', 'gridCells'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
            'nama' => 'required|string|max:100',
            'merk' => 'nullable|string|max:100',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'bahan_aktif' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rack_id' => 'nullable|exists:racks,id',
            'lokasi_rak' => 'nullable|string|max:100',
            'categories' => 'array',
            'problems' => 'array',
        ]);

        if ($request->hasFile('foto')) {
            if ($product->foto && Storage::disk('public')->exists($product->foto)) {
                Storage::disk('public')->delete($product->foto);
            }
            $validated['foto'] = $request->file('foto')->store('products', 'public');
        }

        $product->update($validated);

        $product->categories()->sync($request->input('categories', []));
        $product->problems()->sync($request->input('problems', []));

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->foto && Storage::disk('public')->exists($product->foto)) {
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
