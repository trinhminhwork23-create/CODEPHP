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
    // Named 'login' (canonical — required by Laravel's built-in auth middleware for unauthenticated redirects)
    // AND referenced as 'auth.login' throughout views/controllers — both names resolve to the same URL.
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.submit');

    // Register
    // Named 'register' (canonical — required by Laravel's built-in auth middleware for guest redirects)
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    // Password Recovery Mock routes
    Route::get('/password/reset', fn() => view('auth.passwords.email'))->name('password.request');
    Route::post('/password/email', fn() => back()->with('status', 'Chúng tôi đã gửi link đặt lại mật khẩu vào địa chỉ email của bạn!'))->name('password.email');
});

// Logout (authenticated users only)
Route::any('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

