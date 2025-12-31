<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StaticPageController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [ProductController::class,'show']
)->name('home');

Route::get('/dashboard', [ProductController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/verify/payment', [PaymentController::class, 'verify'])->name('payment.verify');


Route::get('/', [HomeController::class, 'show']);

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

//Pages
Route::view('/terms-and-conditions', 'pages.terms-and-conditions')->name('conditions');

Route::get('/payment/pay/{order}', [PaymentController::class, 'pay'])->name('payment.pay');
 Route::any('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
//product
Route::get('/product/{product}', [ProductController::class, 'mount'])->name('product.show');

require __DIR__.'/auth.php';
