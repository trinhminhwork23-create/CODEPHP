<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReviewController;

/*
|--------------------------------------------------------------------------
| Admin Routes
| Prefix: /admin — Applied in web.php via Route::prefix('admin')
| Middleware: ['auth', 'admin'] — Applied in web.php wrapping group
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

// Categories
Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

// Rooms
Route::get('/rooms', [AdminRoomController::class, 'index'])->name('admin.rooms.index');
Route::get('/rooms/create', [AdminRoomController::class, 'create'])->name('admin.rooms.create');
Route::post('/rooms', [AdminRoomController::class, 'store'])->name('admin.rooms.store');
Route::get('/rooms/{room}/edit', [AdminRoomController::class, 'edit'])->name('admin.rooms.edit');
Route::put('/rooms/{room}', [AdminRoomController::class, 'update'])->name('admin.rooms.update');
Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])->name('admin.rooms.destroy');

// Bookings
Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
Route::patch('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('admin.bookings.approve');
Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('admin.bookings.cancel');

// Users
Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');

// Reviews
Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
Route::patch('/reviews/{review}/toggle-visibility', [AdminReviewController::class, 'toggleVisibility'])->name('admin.reviews.toggleVisibility');
Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
