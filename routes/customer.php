<?php

use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\LoginController;
use App\Http\Controllers\Customer\RegisterController;
use Illuminate\Support\Facades\Route;

// ── Guest-only routes ─────────────────────────────────────────────────────────
Route::middleware('guest:customer')->group(function () {
    Route::get('/register',  [RegisterController::class, 'create'])->name('customer.register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:5,1');

    Route::get('/login',  [LoginController::class, 'create'])->name('customer.login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:6,1');
});

// ── Authenticated customer routes ─────────────────────────────────────────────
Route::middleware('auth.customer:customer')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('customer.account');
});

// ── Logout (any authenticated state) ─────────────────────────────────────────
Route::post('/logout', [LoginController::class, 'destroy'])->name('customer.logout');
