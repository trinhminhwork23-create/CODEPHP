<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class AdminBookingController extends Controller
{
    // Hiển thị danh sách tất cả đơn đặt phòng
    public function index()
    {
        $bookings = Booking::with(['user', 'room'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    // Xem chi tiết một đơn đặt phòng
    public function show($id)
    {
        $booking = Booking::with(['user', 'room', 'payment'])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    // Duyệt đơn đặt phòng — chuyển trạng thái sang APPROVED
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        // Chỉ duyệt đơn đang ở trạng thái chờ duyệt
        if ($booking->status !== Booking::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Chỉ có thể duyệt đơn đang ở trạng thái chờ xử lý!');
        }

        $booking->status = Booking::STATUS_APPROVED;
        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Đơn đặt phòng #' . $booking->id . ' đã được duyệt thành công!');
    }

    // Hủy đơn đặt phòng — chuyển trạng thái sang CANCELLED
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // Không cho hủy đơn đã thanh toán
        if ($booking->status === Booking::STATUS_PAID) {
            return redirect()->back()->with('error', 'Không thể hủy đơn đã thanh toán! Vui lòng liên hệ bộ phận tài chính.');
        }

        $booking->status = Booking::STATUS_CANCELLED;
        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Đơn đặt phòng #' . $booking->id . ' đã bị hủy.');
    }
}
