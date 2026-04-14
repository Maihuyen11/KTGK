<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopController3;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';

Route::get('/profile', function () {
    return view('profile'); 
})->name('profile.edit');


//Danh sách laptop
Route::get('/laptops', [LaptopController3::class, 'index'])->name('laptops.index');

// Xóa mềm
Route::delete('/laptops/{id}', [LaptopController3::class, 'destroy'])->name('laptops.destroy');
Route::get('/laptop/create', [LaptopController3::class, 'create'])->name('laptops.create');
Route::post('/laptops', [LaptopController3::class, 'store'])->name('laptops.store');
Route::get('/laptops/{id}', [LaptopController3::class, 'detail'])->name('laptops.show');