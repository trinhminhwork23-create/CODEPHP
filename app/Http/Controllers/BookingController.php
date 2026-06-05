<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Room;
use App\Models\Booking;

class BookingController extends Controller
{
    // 1. Gọi Stored Procedure của người A để lọc phòng trống cho khách xem
    public function searchRooms(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        // Gọi Procedure do người A viết sẵn trong hệ thống DB
        $vacantRooms = DB::select("CALL CheckVacantRooms(?, ?)", [$request->check_in, $request->check_out]);
        
        // Trả kết quả về cho FE đổ dữ liệu lên giao diện
        return view('bookings.index', compact('vacantRooms'));
    }

    // 2. Tiếp nhận yêu cầu bấm Đặt phòng - Xử lý bẫy "Late Login" cực khôn ngoan
    public function checkoutPreview(Request $request)
    {
        // Lưu dữ liệu đặt phòng tạm thời vào một mảng dữ liệu sạch
        $bookingData = [
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
        ];

        // Nếu khách chưa kịp đăng nhập tài khoản (Late Login)
        if (!Auth::check()) {
            // Ném toàn bộ thông tin đặt phòng vào Session ghi nhớ của máy khách
            Session::put('late_login_booking', $bookingData);
            // Ép hướng đi qua trang đăng nhập của hệ thống
            return redirect()->route('login')->with('info', 'Hệ thống Sapa Jade Hill yêu cầu bạn đăng nhập để giữ chỗ phòng!');
        }

        return $this->showCheckoutPage($bookingData);
    }

    // Hàm phụ trợ hỗ trợ giải phóng Session sau khi login thành công (Hỗ trợ FE)
    private function showCheckoutPage($data)
    {
        $room = Room::findOrFail($data['room_id']);
        
        // Tính toán số đêm lưu trú để tính tiền chính xác
        $days = (strtotime($data['check_out']) - strtotime($data['check_in'])) / 86400;
        $totalPrice = $room->price * $days;

        return view('bookings.checkout', compact('room', 'data', 'totalPrice'));
    }

    // 3. Khách ấn nút xác nhận tạo đơn hàng chính thức
    public function confirmBooking(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'payment_option' => 'required|in:deposit,full' // deposit: cọc 50%, full: 100%
        ]);

        // [XỬ LÝ BẪY BẢO MẬT: RACE CONDITION] Kiểm tra lại xem 5 giây vừa qua phòng còn trống không?
        $isStillVacant = DB::select("CALL CheckVacantRooms(?, ?)", [$request->check_in, $request->check_out]);
        $roomIds = collect($isStillVacant)->pluck('id')->toArray();

        if (!in_array($request->room_id, $roomIds)) {
            return redirect()->back()->with('error', 'Thành thật xin lỗi! Phòng vừa có khách nhanh tay đặt trước mất rồi.');
        }

        // Nếu phòng an toàn trống, tiến hành ghi đè thông tin tạo đơn hàng vào DB người A
        $room = Room::find($request->room_id);
        $days = (strtotime($request->check_out) - strtotime($request->check_in)) / 86400;
        $totalAmount = $room->price * $days;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'adults' => $request->adults ?? 1,   // Thêm thông tin người lớn
            'children' => $request->children ?? 0, // Thêm thông tin trẻ em
            'total_money' => $totalAmount,       // Đổi từ total_price thành total_money
            'status' => Booking::STATUS_PENDING  // Sử dụng hằng số của FE thay vì chuỗi 'pending'
        ]);

        // Chuyển thẳng sang hàm sinh cổng link VNPAY để nạp tiền giao dịch
        return redirect()->route('payment.vnpay.redirect', ['booking_id' => $booking->id, 'option' => $request->payment_option]);
    }

    // 4. Lấy lịch sử đặt phòng của khách hàng
    public function history()
    {
        // Kiểm tra xem khách đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử.');
        }

        // Lấy tất cả đơn hàng của user, dùng with('room') để tối ưu hóa truy vấn (Eager Loading)
        // Nếu không có with('room'), mỗi vòng lặp trong view sẽ phải truy vấn DB 1 lần, rất tốn tài nguyên
        $bookings = Booking::where('user_id', Auth::id())
                            ->with('room') 
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('history.history', compact('bookings'));
    }
}

