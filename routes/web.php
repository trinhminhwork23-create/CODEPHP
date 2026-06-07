<?php
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\DashboardController;

// ── LUỒNG KHÁCH HÀNG KHÔNG CẦN ĐĂNG NHẬP (Để FE làm trang chủ/tìm kiếm)
Route::get('/rooms/search', [BookingController::class, 'searchRooms'])->name('rooms.search');

// ── Static pages ─────────────────────────────────────────────────────────────
Route::get('/about',   fn() => view('about'))->name('about');

// 1. Tuyến đường GET: Dùng để hiển thị giao diện form cho khách xem
Route::get('/contact', fn() => view('contact'))->name('contact');

// 2. Tuyến đường POST (MỚI THÊM): Dùng để hứng dữ liệu khi khách bấm nút Submit ở form
Route::post('/contact-submit', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// ── Blog (static views — no DB model required) ───────────────────────────────
Route::get('/blog',        fn() => view('blog.index'))->name('blog.index');
Route::get('/blog/{id}',   fn() => view('blog.show'))->name('blog.show');

    // Lịch sử hành trình & Đánh giá cá nhân
    Route::get('/profile/history', [ReviewController::class, 'bookingHistory'])->name('profile.history');
    Route::post('/review/store', [ReviewController::class, 'storeReview'])->name('review.store');

// CỔNG NGẦM IPN VNPAY: Không chặn auth vì máy chủ VNPAY tự động gọi ngầm tới cổng này
Route::get('/payment/vnpay-ipn', [PaymentController::class, 'vnpayIpn'])->name('payment.vnpay.ipn');

// ── PHÂN HỆ QUẢN TRỊ ADMIN (Chặn bằng middleware check quyền của bạn A)
Route::middleware(['auth', 'checkadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/toggle', [AdminReviewController::class, 'toggleVisibility'])->name('reviews.toggle');
});
