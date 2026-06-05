<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Customer-Facing Routes
| Public routes are accessible by guests.
| Protected routes require ['auth', 'banned'] middleware.
|--------------------------------------------------------------------------
*/

// ── Public: Rooms ────────────────────────────────────────────────────────────

// Browse all rooms
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

// Search & filter available rooms (POST from search form with check-in, check-out, guests)
Route::post('/rooms/search', [RoomController::class, 'search'])->name('rooms.search');

// Room detail page
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

// ── Protected: Booking & Payment ─────────────────────────────────────────────

Route::middleware(['auth', 'banned'])->group(function () {

    // Show checkout/confirmation form for a specific room
    Route::get('/bookings/checkout/{room}', [BookingController::class, 'checkout'])->name('bookings.checkout');

    // Submit the booking form (creates Booking record, triggers DB trigger for total_money)
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // Cancel a booking (customer-side)
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Initiate VNPAY payment for a confirmed booking
    Route::get('/payment/{booking}/pay', [PaymentController::class, 'initiate'])->name('payment.initiate');

    // VNPAY redirect callback (user lands here after bank payment page)
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

    // VNPAY IPN endpoint (server-to-server notification from VNPAY)
    Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');

    // Payment success confirmation page
    Route::get('/bookings/success', [BookingController::class, 'success'])->name('bookings.success');

    // Booking history page (customer's own past & upcoming bookings)
    Route::get('/profile/history', [BookingController::class, 'history'])->name('profile.history');

    // Submit a review for a room (only after a completed stay)
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
