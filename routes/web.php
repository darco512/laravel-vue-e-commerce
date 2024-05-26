<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactUsController;
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
Route::get('/shop/product/{id}', [ShopController::class, 'product'])->name('product');

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
    Route::get('/admin/products', [AdminController::class, 'products'])->name('products');
    Route::get('/admin/products/add', [AdminController::class, 'add'])->name('products.add');
});

require __DIR__.'/auth.php';
