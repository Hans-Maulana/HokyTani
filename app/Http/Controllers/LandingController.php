<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Problem;
use App\Models\Rack;
use App\Models\StoreGrid;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Load main categories with subcategories
        $mainCategories = Category::main()
            ->with(['children' => function ($q) {
                $q->withCount('products');
            }])
            ->withCount('products')
            ->get();

        $allCategories = Category::with('parent')->get();
        $problems = Problem::withCount('products')->get();
        $racks = Rack::withCount('products')->get();
        $gridCells = StoreGrid::orderBy('row_idx')->orderBy('col_idx')->get();

        $query = Product::with(['categories.parent', 'problems', 'rack']);

        // Search Filter
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Category & Subcategory Filter
        $selectedCategory = null;
        if ($request->filled('category_id')) {
            $catId = $request->category_id;
            $selectedCategory = Category::with('children')->find($catId);

            if ($selectedCategory) {
                $targetIds = [$selectedCategory->id];
                if ($selectedCategory->children->isNotEmpty()) {
                    $targetIds = array_merge($targetIds, $selectedCategory->children->pluck('id')->toArray());
                }

                $query->whereHas('categories', function ($q) use ($targetIds) {
                    $q->whereIn('categories.id', $targetIds);
                });
            }
        }

        // Problem Filter
        if ($request->filled('problem_id')) {
            $query->whereHas('problems', function ($q) use ($request) {
                $q->where('problems.id', $request->problem_id);
            });
        }

        $products = $query->latest()->get();

        return view('welcome', compact('mainCategories', 'allCategories', 'problems', 'racks', 'gridCells', 'products', 'selectedCategory'));
    }
}
