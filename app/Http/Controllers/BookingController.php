<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    private function parseDate($dateStr)
    {
        if (!$dateStr) return null;
        $formats = ['d/m/Y', 'j F, Y', 'Y-m-d', 'd-m-Y', 'j M, Y', 'd M Y'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, trim($dateStr))->format('Y-m-d');
            } catch (\Exception $e) {}
        }
        try {
            return Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * SỬA LOGIC GIỮ PHÒNG: Tự động nhả phòng quá 10 phút và Không chặn chính ID người đặt
     */
    private function isRoomAvailable(int $roomId, string $checkIn, string $checkOut): bool
    {
        // VẤN ĐỀ 10: Tự động nhả các hóa đơn chờ thanh toán (PENDING) đã quá 10 phút trước khi check phòng trống
        Booking::where('status', Booking::STATUS_PENDING)
            ->where('created_at', '<', Carbon::now()->subMinutes(10))
            ->update(['status' => Booking::STATUS_CANCELLED]);

        // VẤN ĐỀ 11: Chỉ khóa phòng thực tế khi đơn đã duyệt/thanh toán HOẶC đơn PENDING của NGƯỜI KHÁC
        return !Booking::where('room_id', $roomId)
            ->where(function ($query) {
                $query->whereIn('status', [Booking::STATUS_APPROVED, Booking::STATUS_PAID])
                    ->orWhere(function ($subQ) {
                        $subQ->where('status', Booking::STATUS_PENDING)
                             ->where('user_id', '!=', Auth::id()); // Không chặn chính chủ tài khoản này
                    });
            })
            ->where('check_in',  '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->exists();
    }

    // 1. Tìm kiếm phòng trống theo ngày
    public function searchRooms(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        // ĐỒNG BỘ VẤN ĐỀ 10 & 11 VÀO HÀM SEARCH: Tự động nhả phòng chờ quá 10p và cho khách thấy lại phòng của chính mình
        Booking::where('status', Booking::STATUS_PENDING)
            ->where('created_at', '<', Carbon::now()->subMinutes(10))
            ->update(['status' => Booking::STATUS_CANCELLED]);

        $vacantRooms = Room::with('category')
            ->whereDoesntHave('bookings', function ($q) use ($request) {
                $q->where(function ($query) {
                        $query->whereIn('status', [Booking::STATUS_APPROVED, Booking::STATUS_PAID])
                            ->orWhere(function ($subQ) {
                                $subQ->where('status', Booking::STATUS_PENDING)
                                     ->where('user_id', '!=', Auth::id());
                            });
                    })
                    ->where('check_in',  '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            })
            ->orderBy('price')
            ->get();

        return view('bookings.index', compact('vacantRooms'));
    }

    // 2. Trang thanh toán chi tiết (Checkout)
    public function checkout(Room $room, Request $request)
    {
        $checkInRaw  = $request->input('check_in')  ?? session('late_login_booking.check_in');
        $checkOutRaw = $request->input('check_out') ?? session('late_login_booking.check_out');

        $checkIn  = $checkInRaw  ? ($this->parseDate($checkInRaw)  ?? date('Y-m-d')) : date('Y-m-d');
        $checkOut = $checkOutRaw ? ($this->parseDate($checkOutRaw) ?? date('Y-m-d', strtotime('+1 day'))) : date('Y-m-d', strtotime('+1 day'));

        $request->merge([
            'check_in'  => $checkIn,
            'check_out' => $checkOut,
        ]);

        $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $adults   = $request->input('adults')   ?? session('late_login_booking.adults')   ?? 1;
        $children = $request->input('children') ?? session('late_login_booking.children') ?? 0;

        $bookingData = [
            'room_id'   => $room->id,
            'check_in'  => $checkIn,
            'check_out' => $checkOut,
            'adults'    => (int)$adults,
            'children'  => (int)$children,
        ];

        // VẤN ĐỀ 2: Khách chưa đăng nhập -> Lưu dữ liệu mảng sạch vào Session trước khi đá sang Login
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

    // 3. Khách xác nhận tạo đơn
    public function confirmBooking(Request $request)
    {
        if ($request->has('check_in')) {
            $request->merge(['check_in' => $this->parseDate($request->check_in)]);
        }
        if ($request->has('check_out')) {
            $request->merge(['check_out' => $this->parseDate($request->check_out)]);
        }

        // VẤN ĐỀ 5: Bổ sung validate dữ liệu đầu vào cho người lớn và trẻ em từ request
        $validated = $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'check_in'       => 'required|date|after_or_equal:today',
            'check_out'      => 'required|date|after:check_in',
            'payment_option' => 'required|in:deposit,full',
            'adults'         => 'required|integer|min:1',
            'children'       => 'nullable|integer|min:0',
        ]);

        // VẤN ĐỀ 5: KIỂM TRA SỨC CHỨA DYNAMIC - SO SÁNH TỔNG SỐ KHÁCH VỚI CAPACITY TRONG DB
        $room = Room::findOrFail($validated['room_id']);
        $totalGuests = (int)$validated['adults'] + (int)($validated['children'] ?? 0);
        if ($totalGuests > $room->capacity) {
            return redirect()->back()->withInput()
                ->withErrors(['adults' => "Tổng số lượng người ({$totalGuests} khách) vượt quá sức chứa tối đa của phòng này ({$room->capacity} người)!"]);
        }

        if (!$this->isRoomAvailable((int) $validated['room_id'], $validated['check_in'], $validated['check_out'])) {
            return redirect()->back()->withInput()
                ->withErrors(['check_in' => 'Thành thật xin lỗi! Phòng đã có khách đặt trước hoặc không khả dụng trong khoảng thời gian này.']);
        }

        $nights = max(1, Carbon::parse($validated['check_in'])->diffInDays(Carbon::parse($validated['check_out'])));

        try {
            $booking = Booking::create([
                'user_id'     => Auth::id(),
                'room_id'     => $validated['room_id'],
                'check_in'    => $validated['check_in'],
                'check_out'   => $validated['check_out'],
                'adults'      => $validated['adults'],
                'children'    => $validated['children'] ?? 0,
                'total_money' => $room->price * $nights,
                'status'      => Booking::STATUS_PENDING,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }

        return redirect()->route('payment.initiate', [
            'booking' => $booking->id,
            'option'  => $validated['payment_option'],
        ]);

        // Chuyển thẳng sang hàm sinh cổng link VNPAY để nạp tiền giao dịch
        return redirect()->route('payment.vnpay.redirect', ['booking_id' => $booking->id, 'option' => $request->payment_option]);
    }

    public function store(Request $request)
    {
        return $this->confirmBooking($request);
    }

    public function success(Request $request)
    {
        return view('bookings.success', [
            'message'   => 'Đặt phòng thành công! Cảm ơn quý khách đã tin tưởng Sapa Jade Hill.',
            'bookingId' => $request->query('booking_id'),
        ]);
    }

    // 5. Khách tự hủy đơn
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_APPROVED])) {
            
            // VẤN ĐỀ 8: TÍNH KHOẢNG CÁCH NGÀY CHẶN HỦY PHÒNG SÁT NGÀY (< 15 NGÀY)
            $daysToCheckIn = Carbon::now()->startOfDay()->diffInDays(Carbon::parse($booking->check_in)->startOfDay(), false);
            if ($daysToCheckIn < 15) {
                return redirect()->back()->with('error', 'Không thể hủy phòng! Quy định hệ thống không cho phép hủy đơn khi cách ngày nhận phòng dưới 15 ngày.');
            }

            $booking->update(['status' => Booking::STATUS_CANCELLED]);
            return redirect()->back()->with('success', 'Đơn đặt phòng đã được hủy thành công.');
        }

        return view('history.history', compact('bookings'));
    }
}
