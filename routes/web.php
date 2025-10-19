<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StaticPageController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/guest', [ProductController::class,'show']
);

Route::get('/dashboard', function () {
    return view('guest.welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/', [HomeController::class, 'show']);

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

//Pages
Route::view('/terms-and-conditions', 'pages.terms-and-conditions')->name('terms.conditions');

//product
Route::get('/product/{product}', [ProductController::class, 'mount'])->name('product.show');

require __DIR__.'/auth.php';
