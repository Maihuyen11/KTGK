<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopController2;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



// Route Câu 5
Route::post('/timkiem', [LaptopController2::class, 'search'])->name('laptop.search');

// Route Câu 4
Route::get('/gio-hang', [LaptopController2::class, 'viewCart'])->name('cart.index');
Route::get('/cart/remove/{id}', [LaptopController2::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [LaptopController2::class, 'checkout'])->name('cart.checkout')->middleware('auth');

