<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';

Route::get('/profile', function () {
    return view('profile'); 
})->name('profile.edit');



use App\Http\Controllers\LaptopController2;

// Route Câu 5
Route::post('/timkiem', [LaptopController2::class, 'search'])->name('laptop.search');

// Route Câu 4
Route::get('/gio-hang', [LaptopController2::class, 'viewCart'])->name('cart.index');
Route::get('/cart/remove/{id}', [LaptopController2::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [LaptopController2::class, 'checkout'])->name('cart.checkout')->middleware('auth');

