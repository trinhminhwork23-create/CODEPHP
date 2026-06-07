<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Admin Routes
| Prefix: /admin — Applied in web.php via Route::prefix('admin')
| Middleware: ['auth', 'admin'] — Applied in web.php wrapping group
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Categories
Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

// Rooms
Route::get('/rooms', [AdminRoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/create', [AdminRoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms', [AdminRoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}/edit', [AdminRoomController::class, 'edit'])->name('rooms.edit');
Route::put('/rooms/{room}', [AdminRoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])->name('rooms.destroy');

// Bookings
Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
Route::patch('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
Route::patch('/bookings/{booking}/checkin', [AdminBookingController::class, 'checkin'])->name('bookings.checkin');
Route::patch('/bookings/{booking}/checkout', [AdminBookingController::class, 'checkout'])->name('bookings.checkout');

// Users
Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');

// Reviews
Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
Route::patch('/reviews/{review}/toggle-visibility', [AdminReviewController::class, 'toggleVisibility'])->name('reviews.toggleVisibility');
Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

// Activity Logs
Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');

// Notifications
Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifications/dropdown', [App\Http\Controllers\Admin\NotificationController::class, 'dropdown']);
Route::get('/logs/latest', [App\Http\Controllers\Admin\NotificationController::class, 'latest']);
