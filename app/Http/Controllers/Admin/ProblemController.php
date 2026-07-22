<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Problem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProblemController extends Controller
{
    public function index()
    {
        $problems = Problem::withCount('products')->latest()->paginate(10);
        return view('admin.problems.index', compact('problems'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.problems.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tipe' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'products' => 'array',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('problems', 'public');
        }

        $problem = Problem::create($validated);

        if ($request->has('products')) {
            $problem->products()->sync($request->products);
        }

        return redirect()->route('admin.problems.index')->with('success', 'Data Masalah Pertanian berhasil ditambahkan.');
    }

    public function edit(Problem $problem)
    {
        $products = Product::all();
        return view('admin.problems.edit', compact('problem', 'products'));
    }

    public function update(Request $request, Problem $problem)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tipe' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'products' => 'array',
        ]);

        if ($request->hasFile('foto')) {
            if ($problem->foto && Storage::disk('public')->exists($problem->foto)) {
                Storage::disk('public')->delete($problem->foto);
            }
            $validated['foto'] = $request->file('foto')->store('problems', 'public');
        }

        $problem->update($validated);
        $problem->products()->sync($request->input('products', []));

        return redirect()->route('admin.problems.index')->with('success', 'Data Masalah Pertanian berhasil diperbarui.');
    }

    public function destroy(Problem $problem)
    {
        if ($problem->foto && Storage::disk('public')->exists($problem->foto)) {
            Storage::disk('public')->delete($problem->foto);
        }

        $problem->delete();

        return redirect()->route('admin.problems.index')->with('success', 'Data Masalah Pertanian berhasil dihapus.');
    }
}
