<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('product');
Route::post('/product', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'show'])->name('show');
Route::get('/sucsses', function () {
    return view('sucsses');
})->name('sucsses');
Route::post('/order', [OrderController::class, 'store'])->name('store');
Route::get('/orders', [OrderController::class, 'index'])->name('index');


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Обработка авторизации
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Показать форму для регистрации
Route::get('register', [LoginController::class, 'showRegistrationForm'])->name('register');

// Обработка регистрации
Route::post('register', [LoginController::class, 'register']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::put('/admin/orders/{order}', [AdminController::class, 'updateStatus'])->name('admin.update-status');
});
Route::post('/admin/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.updateStatus');