<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Room;
use App\Models\Booking;
use App\Models\ActivityLog;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Parse any user-submitted date string into canonical Y-m-d.
     * Priority: dd/mm/yyyy (datepicker) → various fallbacks → Carbon::parse.
     */
    private function parseDate($dateStr)
    {
        if (!$dateStr) return null;

        $formats = ['d/m/Y', 'j F, Y', 'Y-m-d', 'd-m-Y', 'j M, Y', 'd M Y'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, trim($dateStr))->format('Y-m-d');
            } catch (\Exception $e) {
                // try next
            }
        }
        try {
            return Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 🛡️ LAZY CHECK: Auto-expire bookings that are stuck in pending state > 1 minute
     * This method scans for pending bookings (status 0) older than 1 minute and cancels them
     * Rooms are automatically released via Eloquent-based availability logic
     * Called at the start of critical user-facing methods to ensure data consistency
     */
    private function applyLazyCheck()
    {
        $expirationThreshold = now()->subMinutes(1);

        // Find all pending bookings older than 1 minute
        $expiredBookings = Booking::where('status', Booking::STATUS_PENDING)
            ->where('created_at', '<', $expirationThreshold)
            ->get();

        if ($expiredBookings->isEmpty()) {
            return; // No expired bookings found
        }

        // Batch update expired bookings to cancelled status
        foreach ($expiredBookings as $expiredBooking) {
            $expiredBooking->update(['status' => Booking::STATUS_CANCELLED]);

            \Log::info('⏰ Lazy Check: Booking auto-expired', [
                'booking_id' => $expiredBooking->id,
                'room_id' => $expiredBooking->room_id,
                'created_at' => $expiredBooking->created_at,
                'expired_at' => now(),
                'age_minutes' => $expiredBooking->created_at->diffInMinutes(now()),
            ]);
        }

        \Log::info('⏰ Lazy Check completed', [
            'expired_count' => $expiredBookings->count(),
            'threshold' => $expirationThreshold,
        ]);
    }

    /**
     * Eloquent-based room availability check (no stored procedures).
     * Returns TRUE when no overlapping active booking exists.
     */
    private function isRoomAvailable(int $roomId, string $checkIn, string $checkOut): bool
    {
        return !Booking::where('room_id', $roomId)
            ->whereIn('status', [
                Booking::STATUS_PENDING,
                Booking::STATUS_DEPOSIT_PAID,
                Booking::STATUS_PAID,
            ])
            ->where('check_in',  '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->exists();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 1. Tìm kiếm phòng trống theo ngày — public, no auth required
    // ─────────────────────────────────────────────────────────────────────────
    public function searchRooms(Request $request)
    {
        // 🛡️ Inject lazy check to auto-expire stale pending bookings
        $this->applyLazyCheck();

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
            'check_in.required'       => 'Vui lòng chọn ngày nhận phòng.',
            'check_in.date'           => 'Ngày nhận phòng không hợp lệ.',
            'check_in.after_or_equal' => 'Ngày nhận phòng phải từ hôm nay trở đi.',
            'check_out.required'      => 'Vui lòng chọn ngày trả phòng.',
            'check_out.date'          => 'Ngày trả phòng không hợp lệ.',
            'check_out.after'         => 'Ngày trả phòng phải sau ngày nhận phòng.',
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

    // ─────────────────────────────────────────────────────────────────────────
    // 2. Trang chi tiết checkout cho phòng cụ thể
    //    — Late Login (UC Đặt phòng nhanh - Luồng phụ 1):
    //      Nếu khách chưa đăng nhập → lưu session 'pending_booking' → redirect login
    //    — Sau khi đăng nhập quay lại → LoginController khôi phục session này
    // ─────────────────────────────────────────────────────────────────────────
    public function checkout(Room $room, Request $request)
    {
        // 🛡️ Inject lazy check to auto-expire stale pending bookings
        $this->applyLazyCheck();

        // Resolve dates: prefer URL params, fall back to restored session
        $pending     = session('pending_booking', []);
        $checkInRaw  = $request->input('check_in')  ?? ($pending['check_in']  ?? null);
        $checkOutRaw = $request->input('check_out') ?? ($pending['check_out'] ?? null);

        $checkIn  = $checkInRaw  ? ($this->parseDate($checkInRaw)  ?? date('Y-m-d'))                        : date('Y-m-d');
        $checkOut = $checkOutRaw ? ($this->parseDate($checkOutRaw) ?? date('Y-m-d', strtotime('+1 day')))   : date('Y-m-d', strtotime('+1 day'));

        $adults   = $request->input('adults')   ?? ($pending['adults']   ?? 1);
        $children = $request->input('children') ?? ($pending['children'] ?? 0);

        // ── Late Login intercept ──────────────────────────────────────────────
        if (!Auth::check()) {
            // Persist all booking intent into session so LoginController can restore it
            session([
                'pending_booking' => [
                    'room_id'   => $room->id,
                    'check_in'  => $checkIn,
                    'check_out' => $checkOut,
                    'adults'    => $adults,
                    'children'  => $children,
                ],
            ]);

            // Force write to storage right now before exiting the request
            session()->save();

            return redirect()->route('login')
                ->with('info', 'Vui lòng đăng nhập để tiếp tục hoàn tất đơn đặt phòng của bạn. Hệ thống đã tự động giữ phòng tạm thời cho bạn!');
        }

        // ── Authenticated: validate dates then render checkout form ───────────
        $request->merge(['check_in' => $checkIn, 'check_out' => $checkOut]);

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

        // Session fulfilled — clear pending booking
        Session::forget('pending_booking');

        $nights     = max(1, Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut)));
        $totalPrice = $room->price * $nights;
        $data = [
            'room_id'   => $room->id,
            'check_in'  => $checkIn,
            'check_out' => $checkOut,
            'adults'    => $adults,
            'children'  => $children,
        ];

        return view('bookings.checkout', compact('room', 'data', 'totalPrice'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 3. Khách xác nhận và tạo đơn — POST /booking/confirm
    //    Race-condition guard bằng Eloquent thuần
    // ─────────────────────────────────────────────────────────────────────────
    public function confirmBooking(Request $request)
    {
        // Normalise date strings from any frontend format → Y-m-d
        if ($request->has('check_in')) {
            $parsed = $this->parseDate($request->check_in);
            if ($parsed) $request->merge(['check_in' => $parsed]);
        }
        if ($request->has('check_out')) {
            $parsed = $this->parseDate($request->check_out);
            if ($parsed) $request->merge(['check_out' => $parsed]);
        }

        $validated = $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'check_in'       => 'required|date',
            'check_out'      => 'required|date|after:check_in',
            'payment_option' => 'required|in:deposit,full',
        ], [
            'room_id.required'        => 'Không tìm thấy thông tin phòng.',
            'room_id.exists'          => 'Phòng này không tồn tại trong hệ thống.',
            'check_in.required'       => 'Vui lòng chọn ngày nhận phòng.',
            'check_in.date'           => 'Ngày nhận phòng không hợp lệ.',
            'check_out.required'      => 'Vui lòng chọn ngày trả phòng.',
            'check_out.date'          => 'Ngày trả phòng không hợp lệ.',
            'check_out.after'         => 'Ngày trả phòng phải sau ngày nhận phòng.',
            'payment_option.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_option.in'       => 'Phương thức thanh toán không hợp lệ.',
        ]);

        // 🛡️ CRITICAL: BACKEND CAPACITY VALIDATION (FIX GHOST BUG)
        $room = Room::findOrFail($validated['room_id']);
        $totalGuests = (int)$request->input('adults', 1) + (int)$request->input('children', 0);
        
        if ($totalGuests > $room->capacity) {
            return redirect()->back()->withInput()
                ->withErrors(['booking' => "Số lượng khách ({$totalGuests} người) vượt quá sức chứa tối đa của phòng ({$room->capacity} người)!"]);
        }

        // Race-condition guard
        if (!$this->isRoomAvailable((int) $validated['room_id'], $validated['check_in'], $validated['check_out'])) {
            return redirect()->back()->withInput()
                ->withErrors(['booking' => 'Thành thật xin lỗi! Phòng vừa có khách nhanh tay đặt trước hoặc không khả dụng trong khoảng thời gian này.']);
        }

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

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'role' => 'Guest',
                'action' => 'Create',
                'target_model' => 'Booking',
                'target_id' => $booking->id,
                'description' => 'Khách ' . Auth::user()->name . ' đã tạo đơn đặt phòng ' . $room->name . ' (ID #' . $booking->id . ')'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Không thể tạo đơn đặt phòng. Vui lòng thử lại.');
        }

        // ── Clean up — prevent session residue / infinite loops ───────────────
        Session::forget('pending_booking');

        return redirect()->route('payment.initiate', [
            'booking' => $booking->id,
            'option'  => $validated['payment_option'],
        ]);
    }

    // Wrapper for bookings.store route
    public function store(Request $request)
    {
        return $this->confirmBooking($request);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 4. Trang thành công sau thanh toán
    // ─────────────────────────────────────────────────────────────────────────
    public function success(Request $request)
    {
        return view('bookings.success', [
            'message'   => 'Đặt phòng thành công! Cảm ơn quý khách đã tin tưởng Sapa Jade Hill.',
            'bookingId' => $request->query('booking_id'),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 4.5. Trang chi tiết đơn đặt phòng (invoice/receipt)
    // ─────────────────────────────────────────────────────────────────────────
    public function show(Booking $booking)
    {
        // 🛡️ Inject lazy check to auto-expire stale pending bookings BEFORE displaying
        $this->applyLazyCheck();

        // Refresh booking from database (in case it was just expired by lazy check)
        $booking->refresh();

        // Ensure user can only view their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn đặt phòng này.');
        }

        $booking->load('room.category', 'user');

        return view('bookings.show', compact('booking'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 5. Khách tự hủy đơn (pending hoặc deposit_paid)
    //    🛡️ CANCELLATION PROTECTION POLICY: Minimum 10 days before check-in
    // ─────────────────────────────────────────────────────────────────────────
    public function cancel(Booking $booking)
    {
        // ── Authorization: Ensure user owns this booking ─────────────────
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền hủy đơn đặt phòng này.');
        }

        // ── Business Rule: Only pending/deposit_paid bookings can be cancelled ───
        if (!in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_DEPOSIT_PAID])) {
            return redirect()->back()->with('error', 'Không thể hủy đơn đặt phòng ở trạng thái này.');
        }

        // 🛡️ CANCELLATION PROTECTION: 10-DAY RULE (STRICT ENFORCEMENT)
        // Calculate days between now and check-in date
        $daysUntilCheckIn = now()->diffInDays(Carbon::parse($booking->check_in), false);

        // If check-in is less than 10 days away, block cancellation
        if ($daysUntilCheckIn < 10) {
            return redirect()->back()->with('error', 
                'Không thể hủy phòng! Theo quy định, quý khách chỉ được phép hủy đơn đặt phòng trước ngày nhận ít nhất 10 ngày.');
        }

        // ── Cancellation allowed: Update status ─────────────────────
        $roomName = $booking->room->name;
        $booking->update(['status' => Booking::STATUS_CANCELLED]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'role' => 'Guest',
            'action' => 'Delete',
            'target_model' => 'Booking',
            'target_id' => $booking->id,
            'description' => 'Khách ' . Auth::user()->name . ' đã hủy đơn đặt phòng ' . $roomName . ' (ID #' . $booking->id . ')'
        ]);

        return redirect()->back()->with('success', 'Đơn đặt phòng đã được hủy thành công.');
    }
}
