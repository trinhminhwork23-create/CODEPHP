<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;

// ── Home ─────────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Static pages ─────────────────────────────────────────────────────────────
Route::get('/about',   fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// ── Blog (static views — no DB model required) ───────────────────────────────
Route::get('/blog',        fn() => view('blog.index'))->name('blog.index');
Route::get('/blog/{id}',   fn() => view('blog.show'))->name('blog.show');

// ── Sub-route files ───────────────────────────────────────────────────────────
require __DIR__.'/auth_routes.php';
require __DIR__.'/customer_routes.php';

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    require __DIR__.'/admin_routes.php';
});
