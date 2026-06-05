<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
| Guests only — redirect authenticated users away via 'guest' middleware
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [LoginController::class, 'showForm'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.submit');

    // Register
    Route::get('/register', [RegisterController::class, 'showForm'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('auth.register.submit');
});

// Logout (authenticated users only)
Route::any('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');