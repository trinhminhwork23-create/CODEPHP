<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Hủy đơn đặt phòng cưỡng chế bởi Admin — chuyển trạng thái sang CANCELLED
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|min:10|max:1000',
        ], [
            'cancel_reason.required' => 'Vui lòng nhập lý do hủy đơn!',
            'cancel_reason.min' => 'Lý do hủy phải có ít nhất 10 ký tự.',
            'cancel_reason.max' => 'Lý do hủy không được vượt quá 1000 ký tự.',
        ]);

        $booking = Booking::with('user')->findOrFail($id);

        // Không cho hủy đơn đã hoàn thành
        if (in_array($booking->status, [Booking::STATUS_COMPLETED, Booking::STATUS_CANCELLED])) {
            return redirect()->back()->with('error', 'Không thể hủy đơn đã hoàn thành hoặc đã bị hủy trước đó!');
        }

        $booking->status = Booking::STATUS_CANCELLED;
        $booking->cancel_reason = $request->input('cancel_reason');
        $booking->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'role' => Auth::user()->role === 'admin' ? 'Admin' : 'Staff',
            'action' => 'Delete',
            'target_model' => 'Booking',
            'target_id' => $booking->id,
            'description' => Auth::user()->name . ' đã hủy cưỡng chế đơn đặt phòng ID #' . $booking->id
        ]);

        return redirect()->back()->with('success', 'Hủy đơn cưỡng chế thành công! [MÔ PHỎNG HOÀN TIỀN]: Hệ thống đã tự động kích hoạt lệnh hoàn trả số tiền ' . number_format($booking->total_money, 0, ',', '.') . ' VNĐ về tài khoản thẻ/VNPAY của khách hàng. [MÔ PHỎNG GỬI EMAIL TỰ ĐỘNG]: Đã gửi thông báo hủy đơn kèm lý do "' . $request->cancel_reason . '" tự động đến email của khách hàng (' . $booking->user->email . ') thành công.');
    }

    // Xác nhận Nhận phòng — chuyển từ Đã đặt cọc hoặc Đã thanh toán sang Đã nhận phòng
    public function checkin($id)
    {
        $booking = Booking::findOrFail($id);

        if (!in_array($booking->status, [Booking::STATUS_DEPOSIT_PAID, Booking::STATUS_PAID])) {
            return redirect()->back()->with('error', 'Chỉ có thể nhận phòng cho đơn đã đặt cọc hoặc đã thanh toán!');
        }

        $booking->status = Booking::STATUS_CHECKED_IN;
        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Đã xác nhận nhận phòng cho đơn #' . $booking->id);
    }

    // Xác nhận Trả phòng — chuyển từ Đã nhận phòng sang Hoàn thành
    public function checkout($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== Booking::STATUS_CHECKED_IN) {
            return redirect()->back()->with('error', 'Chỉ có thể trả phòng cho đơn đã nhận phòng!');
        }

        $booking->status = Booking::STATUS_COMPLETED;
        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Đã xác nhận trả phòng cho đơn #' . $booking->id . '. Khách hàng có thể gửi đánh giá.');
    }
}
