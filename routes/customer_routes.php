<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Customer-Facing Routes
| Public routes are accessible by guests.
| Protected routes require ['auth', 'banned'] middleware.
|--------------------------------------------------------------------------
*/

// ── Public: Rooms ────────────────────────────────────────────────────────────

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/suggestions', [RoomController::class, 'getSuggestions'])->name('rooms.suggestions');
Route::get('/rooms/search', [RoomController::class, 'search'])->name('rooms.search');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

// ── Protected: Booking & Payment ─────────────────────────────────────────────

Route::middleware(['auth', 'banned'])->group(function () {

    // Show checkout/confirmation form for a specific room
    Route::get('/bookings/checkout/{room}', [BookingController::class, 'checkout'])->name('bookings.checkout');

    // Show booking detail page (invoice/receipt view)
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    // Submit the booking form (creates Booking record, redirects to VNPay)
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // Confirm booking from checkout form — canonical POST target
    Route::post('/booking/confirm', [BookingController::class, 'confirmBooking'])->name('booking.confirm');

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
    Route::get('/profile/history', [ProfileController::class, 'index'])->name('profile.history');

    // Update profile details
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Update security password
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Submit a review for a room (only after a completed stay)
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // ── DEBUG ONLY: Simulate booking timeout for testing room retention ─────
    Route::post('/bookings/{booking}/simulate-timeout', [PaymentController::class, 'simulateTimeout'])
        ->name('bookings.simulateTimeout');
});
