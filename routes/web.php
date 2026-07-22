<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProblemController;
use App\Http\Controllers\Admin\RackController;
use App\Http\Controllers\Admin\StoreMapController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Problem;
use Illuminate\Support\Facades\Route;

// Public Guest Routes (View only)
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Admin Protected Routes (Edit / CRUD)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
            'problems_count' => Problem::count(),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('problems', ProblemController::class);
    Route::resource('racks', RackController::class);

    // Visual Store Floor Plan & Rack Map Route
    Route::get('/store-map', [StoreMapController::class, 'index'])->name('store_map');
    Route::put('/store-map/grid/{grid}', [StoreMapController::class, 'updateCell'])->name('store_map.update_cell');
});

// Alias for dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
