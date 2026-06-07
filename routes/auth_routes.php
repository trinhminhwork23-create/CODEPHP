<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

    // Password Recovery (OTP)
    Route::get('/password/reset',          [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email',         [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/password/verify',         [ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify.form');
    Route::post('/password/verify',        [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify');
    Route::post('/password/resend',        [ForgotPasswordController::class, 'resendOtp'])->name('password.resend');
    Route::get('/password/reset/new',      [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/password/update',        [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// Logout (authenticated users only)
Route::any('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

