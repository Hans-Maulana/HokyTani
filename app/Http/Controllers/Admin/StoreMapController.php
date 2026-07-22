<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StoreGrid;
use Illuminate\Http\Request;

class StoreMapController extends Controller
{
    public function index()
    {
        $gridCells = StoreGrid::orderBy('row_idx')->orderBy('col_idx')->get();
        $products = Product::with(['categories', 'problems'])->get();

        return view('admin.store_map.index', compact('gridCells', 'products'));
    }

    public function updateCell(Request $request, StoreGrid $grid)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:50',
            'zone_type' => 'required|string|max:50',
        ]);

        $colorMap = [
            'etalase' => 'green',
            'rak' => 'blue',
            'kasir' => 'amber',
            'tumpukan' => 'red',
            'jalan' => 'gray',
        ];

        $validated['color'] = $colorMap[$request->zone_type] ?? 'gray';

        $grid->update($validated);

        return redirect()->route('admin.store_map')->with('success', 'Kotak grid denah berhasil diperbarui.');
    }
}
