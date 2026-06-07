<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

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
    public function cancel(\Illuminate\Http\Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Không cho hủy đơn đã thanh toán
        if ($booking->status === Booking::STATUS_PAID) {
            return redirect()->back()->with('error', 'Không thể hủy đơn đã thanh toán! Vui lòng liên hệ bộ phận tài chính.');
        }

        // 1. Ép buộc Admin phải nhập lý do hủy cưỡng chế
        $request->validate([
            'cancel_reason' => 'required|string|max:255'
        ], [
            'cancel_reason.required' => 'Vui lòng nhập lý do hủy đơn cưỡng chế!'
        ]);

        // 2. Cập nhật trạng thái và lý do hủy vào DB
        $booking->status = Booking::STATUS_CANCELLED;
        $booking->cancel_reason = $request->input('cancel_reason');
        $booking->save(); // QUAN TRỌNG: Phải có dòng này thì DB mới thay đổi!

        return redirect()->back()->with('success', 'Đơn đặt phòng #' . $booking->id . ' đã được hủy cưỡng chế thành công!');
    }
}
