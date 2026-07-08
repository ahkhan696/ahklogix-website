<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ── Public routes ─────────────────────────────────────────────────────────────

Route::get('/', HomeController::class)->name('home');

// Services — Phase 3 adds ServiceController
Route::get('/services',        fn () => view('pages.placeholder', ['section' => 'Services']))->name('services.index');
Route::get('/services/{slug}', fn () => view('pages.placeholder', ['section' => 'Service Detail']))->name('services.show');

// Portfolio — Phase 3 adds ProjectController
Route::get('/portfolio',        fn () => view('pages.placeholder', ['section' => 'Portfolio']))->name('portfolio.index');
Route::get('/portfolio/{slug}', fn () => view('pages.placeholder', ['section' => 'Case Study']))->name('portfolio.show');

// POSR product page — Phase 5
Route::get('/posr', fn () => view('pages.placeholder', ['section' => 'POSR']))->name('posr');

// Blog — Phase 6
Route::get('/blog',        fn () => view('pages.placeholder', ['section' => 'Blog']))->name('blog.index');
Route::get('/blog/{slug}', fn () => view('pages.placeholder', ['section' => 'Blog Post']))->name('blog.show');

// About / Contact / FAQ — Phase 5 & 7
Route::get('/about',   fn () => view('pages.placeholder', ['section' => 'About']))->name('about');
Route::get('/contact', fn () => view('pages.placeholder', ['section' => 'Contact']))->name('contact');
Route::get('/faq',     fn () => view('pages.placeholder', ['section' => 'FAQ']))->name('faq');
