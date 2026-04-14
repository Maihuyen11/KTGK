<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopController2;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopController1;



// --- Câu 2: Trang chủ - Danh sách sản phẩm & lọc theo thương hiệu ---
// (Xóa bỏ HomeController cũ để tránh xung đột)
Route::get('/', [LaptopController1::class, 'index'])->name('home');

// --- Trang sau khi đăng nhập (Dashboard) ---
Route::get('/dashboard', [LaptopController1::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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

// --- Câu 3: Trang chi tiết sản phẩm ---
Route::get('/laptop/{id}', [LaptopController1::class, 'show'])->name('laptop.detail');

// --- Xử lý nút Thêm vào giỏ hàng ---
Route::post('/cart/add', [LaptopController1::class, 'addToCart'])->name('cart.add');



// Route lọc sản phẩm theo danh mục (thương hiệu)
Route::get('/laptop/theloai/{id_danh_muc}', [LaptopController1::class, 'index'])->name('laptop.theloai');

