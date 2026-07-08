<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PosrController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;

// ── Public routes ─────────────────────────────────────────────────────────────

Route::get('/', HomeController::class)->name('home');

// Services
Route::get('/services',        [ServicesController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServicesController::class, 'show'])->name('services.show');

// Portfolio
Route::get('/portfolio',        [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

// POSR
Route::get('/posr', PosrController::class)->name('posr');

// Blog — Phase 6
Route::get('/blog',        fn () => view('pages.placeholder', ['section' => 'Blog']))->name('blog.index');
Route::get('/blog/{slug}', fn () => view('pages.placeholder', ['section' => 'Blog Post']))->name('blog.show');

// About + FAQ
Route::get('/about', AboutController::class)->name('about');
Route::get('/faq',   FaqController::class)->name('faq');

// Contact — Phase 7
Route::get('/contact', fn () => view('pages.placeholder', ['section' => 'Contact']))->name('contact');
