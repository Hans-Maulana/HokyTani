<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rack;
use Illuminate\Http\Request;

class RackController extends Controller
{
    public function index()
    {
        $racks = Rack::withCount('products')->latest()->get();
        return view('admin.racks.index', compact('racks'));
    }

    public function create()
    {
        return view('admin.racks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kode_zona' => 'required|string|max:50|unique:racks,kode_zona',
            'deskripsi' => 'nullable|string',
            'keterangan_baris' => 'nullable|string',
        ]);

        Rack::create($validated);

        return redirect()->route('admin.racks.index')->with('success', 'Lokasi Rak / Zona Denah berhasil ditambahkan.');
    }

    public function edit(Rack $rack)
    {
        return view('admin.racks.edit', compact('rack'));
    }

    public function update(Request $request, Rack $rack)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kode_zona' => 'required|string|max:50|unique:racks,kode_zona,' . $rack->id,
            'deskripsi' => 'nullable|string',
            'keterangan_baris' => 'nullable|string',
        ]);

        $rack->update($validated);

        return redirect()->route('admin.racks.index')->with('success', 'Lokasi Rak / Zona Denah berhasil diperbarui.');
    }

    public function destroy(Rack $rack)
    {
        $rack->delete();
        return redirect()->route('admin.racks.index')->with('success', 'Rak berhasil dihapus.');
    }
}
