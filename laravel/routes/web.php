<?php

use App\Http\Controllers\StuntingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm']);

// === AUTH ROUTES ===
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === ROUTES YANG HANYA BISA DIAKSES SETELAH LOGIN ===
Route::middleware('auth')->group(function () {
    Route::get('/beranda', [StuntingController::class, 'welcome'])->name('beranda');
    Route::get('/cek-stunting', [StuntingController::class, 'index'])->name('cek-stunting');
    Route::post('/cek-stunting', [StuntingController::class, 'check'])->name('check-stunting');
});
