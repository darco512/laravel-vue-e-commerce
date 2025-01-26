<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Home', []);
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/aboutus', function () {
    return Inertia::render('AboutUs',['success' => session('success')]);
})->name('aboutus');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/product/{product}', [ShopController::class, 'product'])->name('product');

Route::post('/aboutus/send', [ContactUsController::class, 'send'])->name('send');

// Route::get('/admin', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'isAdmin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products');
    Route::get('/admin/load-more-products', [ProductController::class, 'loadMoreProducts'])->name('products.loadMore');
    Route::get('/admin/filter-options', [ProductController::class, 'filterOptions'])->name('products.filterOptions');
    Route::get('/admin/product/new', [ProductController::class, 'new'])->name('product.new');
    Route::post('/admin/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/admin/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/admin/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/admin/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

require __DIR__.'/auth.php';
