<?php
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\DashboardController;

// ── LUỒNG KHÁCH HÀNG KHÔNG CẦN ĐĂNG NHẬP (Để FE làm trang chủ/tìm kiếm)
Route::get('/rooms/search', [BookingController::class, 'searchRooms'])->name('rooms.search');

// ── LUỒNG KHÁCH HÀNG BẮT BUỘC ĐĂNG NHẬP (Xử lý thông qua Middleware)
Route::middleware(['auth'])->group(function () {
    // Đặt phòng nâng cao
    Route::post('/booking/checkout-preview', [BookingController::class, 'checkoutPreview'])->name('booking.checkout.preview');
    Route::post('/booking/confirm', [BookingController::class, 'confirmBooking'])->name('booking.confirm');

    // Cổng VNPAY (Khách trả tiền)
    Route::get('/payment/vnpay-redirect/{booking_id}', [PaymentController::class, 'createVnpayPayment'])->name('payment.vnpay.redirect');
    Route::get('/payment/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');

    // Lịch sử hành trình & Đánh giá cá nhân
    Route::get('/profile/history', [ReviewController::class, 'bookingHistory'])->name('profile.history');
    Route::post('/review/store', [ReviewController::class, 'storeReview'])->name('review.store');
});

// CỔNG NGẦM IPN VNPAY: Không chặn auth vì máy chủ VNPAY tự động gọi ngầm tới cổng này
Route::get('/payment/vnpay-ipn', [PaymentController::class, 'vnpayIpn'])->name('payment.vnpay.ipn');

// ── PHÂN HỆ QUẢN TRỊ ADMIN (Chặn bằng middleware check quyền của bạn A)
Route::middleware(['auth', 'checkadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/toggle', [AdminReviewController::class, 'toggleVisibility'])->name('reviews.toggle');
});
