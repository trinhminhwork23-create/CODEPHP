<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Parse a user-submitted date string (from jQuery UI datepicker dd/mm/yy or fallbacks)
     * into a canonical Y-m-d string for DB storage and validation.
     */
    private function parseDate($dateStr)
    {
        if (!$dateStr) return null;

        // Priority order: the active datepicker format first, then fallbacks
        $formats = ['d/m/Y', 'j F, Y', 'Y-m-d', 'd-m-Y', 'j M, Y', 'd M Y'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, trim($dateStr))->format('Y-m-d');
            } catch (\Exception $e) {
                // Try next format
            }
        }

        try {
            return Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Pure Eloquent availability check — replaces CALL CheckVacantRooms(?, ?).
     * Returns TRUE if the room is available (no overlapping active bookings).
     */
    private function isRoomAvailable(int $roomId, string $checkIn, string $checkOut): bool
    {
        return !Booking::where('room_id', $roomId)
            ->whereIn('status', [
                Booking::STATUS_PENDING,
                Booking::STATUS_APPROVED,
                Booking::STATUS_PAID,
            ])
            ->where('check_in',  '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->exists();
    }

    // 1. Tìm kiếm phòng trống theo ngày (thay thế CALL CheckVacantRooms)
    public function searchRooms(Request $request)
    {
        if ($request->has('check_in')) {
            $request->merge(['check_in' => $this->parseDate($request->check_in)]);
        }
        if ($request->has('check_out')) {
            $request->merge(['check_out' => $this->parseDate($request->check_out)]);
        }

        $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ], [
            'check_in.required'          => 'Vui lòng chọn ngày nhận phòng.',
            'check_in.date'              => 'Ngày nhận phòng không hợp lệ.',
            'check_in.after_or_equal'    => 'Ngày nhận phòng phải từ hôm nay trở đi.',
            'check_out.required'         => 'Vui lòng chọn ngày trả phòng.',
            'check_out.date'             => 'Ngày trả phòng không hợp lệ.',
            'check_out.after'            => 'Ngày trả phòng phải sau ngày nhận phòng.',
        ]);

        $vacantRooms = Room::with('category')
            ->whereDoesntHave('bookings', function ($q) use ($request) {
                $q->whereIn('status', [
                        Booking::STATUS_PENDING,
                        Booking::STATUS_APPROVED,
                        Booking::STATUS_PAID,
                    ])
                    ->where('check_in',  '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            })
            ->orderBy('price')
            ->get();

        return view('bookings.index', compact('vacantRooms'));
    }

    // 2. Trang thanh toán chi tiết (Checkout) cho phòng cụ thể
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
        ], [
            'check_in.required'       => 'Vui lòng chọn ngày nhận phòng.',
            'check_in.date'           => 'Ngày nhận phòng không hợp lệ.',
            'check_in.after_or_equal' => 'Ngày nhận phòng phải từ hôm nay trở đi.',
            'check_out.required'      => 'Vui lòng chọn ngày trả phòng.',
            'check_out.date'          => 'Ngày trả phòng không hợp lệ.',
            'check_out.after'         => 'Ngày trả phòng phải sau ngày nhận phòng.',
        ]);

        $adults   = $request->input('adults')   ?? session('late_login_booking.adults')   ?? 1;
        $children = $request->input('children') ?? session('late_login_booking.children') ?? 0;

        $bookingData = [
            'room_id'   => $room->id,
            'check_in'  => $checkIn,
            'check_out' => $checkOut,
            'adults'    => $adults,
            'children'  => $children,
        ];

        // Late Login — khách chưa đăng nhập
        if (!Auth::check()) {
            Session::put('late_login_booking', $bookingData);
            return redirect()->route('login')
                ->with('info', 'Hệ thống Sapa Jade Hill yêu cầu bạn đăng nhập để giữ chỗ phòng!');
        }

        Session::forget('late_login_booking');

        $nights = max(1, Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut)));
        $totalPrice = $room->price * $nights;
        $data = $bookingData;

        return view('bookings.checkout', compact('room', 'data', 'totalPrice'));
    }

    // 3. Khách xác nhận tạo đơn — kiểm tra race condition bằng Eloquent thuần
    public function confirmBooking(Request $request)
    {
        // Normalise dates from any frontend format → Y-m-d before validation
        if ($request->has('check_in')) {
            $parsed = $this->parseDate($request->check_in);
            if ($parsed) {
                $request->merge(['check_in' => $parsed]);
            }
        }
        if ($request->has('check_out')) {
            $parsed = $this->parseDate($request->check_out);
            if ($parsed) {
                $request->merge(['check_out' => $parsed]);
            }
        }

        $validated = $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'check_in'       => 'required|date|after_or_equal:today',
            'check_out'      => 'required|date|after:check_in',
            'payment_option' => 'required|in:deposit,full',
        ], [
            'room_id.required'        => 'Không tìm thấy thông tin phòng.',
            'room_id.exists'          => 'Phòng này không tồn tại trong hệ thống.',
            'check_in.required'       => 'Vui lòng chọn ngày nhận phòng.',
            'check_in.after_or_equal' => 'Ngày nhận phòng phải từ hôm nay trở đi.',
            'check_out.required'      => 'Vui lòng chọn ngày trả phòng.',
            'check_out.after'         => 'Ngày trả phòng phải sau ngày nhận phòng.',
            'payment_option.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_option.in'       => 'Phương thức thanh toán không hợp lệ.',
        ]);

        // [Race condition guard] Eloquent overlap check
        if (!$this->isRoomAvailable((int) $validated['room_id'], $validated['check_in'], $validated['check_out'])) {
            return redirect()->back()->withInput()
                ->withErrors(['check_in' => 'Thành thật xin lỗi! Phòng vừa có khách nhanh tay đặt trước mất rồi hoặc không khả dụng trong khoảng thời gian này.']);
        }

        $room   = Room::findOrFail($validated['room_id']);
        $nights = max(1, Carbon::parse($validated['check_in'])->diffInDays(Carbon::parse($validated['check_out'])));

        try {
            $booking = Booking::create([
                'user_id'     => Auth::id(),
                'room_id'     => $validated['room_id'],
                'check_in'    => $validated['check_in'],
                'check_out'   => $validated['check_out'],
                'adults'      => $request->input('adults', 1),
                'children'    => $request->input('children', 0),
                'total_money' => $room->price * $nights,
                'status'      => Booking::STATUS_PENDING,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Không thể tạo đơn đặt phòng: ' . $e->getMessage());
        }

        return redirect()->route('payment.initiate', [
            'booking' => $booking->id,
            'option'  => $validated['payment_option'],
        ]);
    }

    // Wrapper cho route bookings.store
    public function store(Request $request)
    {
        return $this->confirmBooking($request);
    }

    // 4. Trang hoàn thành đặt phòng thành công
    public function success(Request $request)
    {
        return view('bookings.success', [
            'message'   => 'Đặt phòng thành công! Cảm ơn quý khách đã tin tưởng Sapa Jade Hill.',
            'bookingId' => $request->query('booking_id'),
        ]);
    }

    // 5. Khách tự hủy đơn (pending hoặc approved)
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_APPROVED])) {
            $booking->update(['status' => Booking::STATUS_CANCELLED]);
            return redirect()->back()->with('success', 'Đơn đặt phòng đã được hủy thành công.');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn đặt phòng ở trạng thái này.');
    }
}
