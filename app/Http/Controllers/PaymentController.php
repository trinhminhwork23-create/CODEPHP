<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Initiate VNPAY payment redirect (OUTBOUND)
     * Strictly follows VNPAY v2.1.0 protocol specification
     * Supports dual-payment: 50% deposit or 100% full payment
     */
    public function initiate(Booking $booking, Request $request)
    {
        // ── RULE 1: Dynamic Configuration Binding ─────────────────────────────
        $vnp_TmnCode = config('services.vnpay.tmn_code') ?? env('VNP_TMN_CODE');
        $vnp_HashSecret = config('services.vnpay.hash_secret') ?? env('VNP_HASH_SECRET');
        $vnp_Url = config('services.vnpay.url') ?? env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');

        // ── RULE 2: Set timezone and prepare transaction reference ───────────
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TxnRef = 'SONA' . $booking->id . 'T' . time();

        // ── Determine payment amount: 50% deposit or 100% full ───────────────
        $paymentOption = $request->query('option', 'full'); // 'deposit' or 'full'
        $totalMoney = (float)$booking->total_money;
        
        if ($paymentOption === 'deposit') {
            $paymentAmount = $totalMoney * 0.5; // 50% deposit
        } else {
            $paymentAmount = $totalMoney; // 100% full payment
        }

        // ── RULE 2: Sanitize amount (prevent trailing decimals) ──────────────
        $vnp_Amount = (int)floor($paymentAmount) * 100;

        // ── Normalize IP address (handle ::1 from XAMPP) ─────────────────────
        $vnp_IpAddr = $request->ip();
        if ($vnp_IpAddr === '::1' || empty($vnp_IpAddr) || filter_var($vnp_IpAddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $vnp_IpAddr = '127.0.0.1';
        }

        // ── Build mandatory 13-field payload ──────────────────────────────────
        $vnp_CreateDate = date('YmdHis');
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes'));

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $vnp_Amount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => $vnp_CreateDate,
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'ThanhToanDonHang' . $vnp_TxnRef,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => route('payment.callback'),
            'vnp_TxnRef' => $vnp_TxnRef,
            'vnp_ExpireDate' => $vnp_ExpireDate
        ];

        // ── RULE 2: VNPAY native sorting loop (DO NOT OPTIMIZE) ──────────────
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        Log::info('VNPAY Payment Initiated', [
            'booking_id' => $booking->id,
            'vnp_txn_ref' => $vnp_TxnRef,
            'vnp_amount' => $vnp_Amount,
            'payment_option' => $paymentOption,
            'payment_percentage' => $paymentOption === 'deposit' ? '50%' : '100%'
        ]);

        return redirect()->away($vnp_Url);
    }

    /**
     * Handle VNPAY callback/return (INBOUND)
     * Validates signature, extracts payment amount, and intelligently assigns booking status
     * Dual-payment matrix: Differentiates between 50% deposit vs 100% full payment
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        // ── RULE 1: Dynamic Configuration Binding ─────────────────────────────
        $vnp_HashSecret = config('services.vnpay.hash_secret') ?? env('VNP_HASH_SECRET');

        // ── RULE 2: Extract and validate incoming signature ──────────────────
        $inputData = [];
        $incomingVnpSecureHash = $request->input('vnp_SecureHash', '');

        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'vnp_') && $key !== 'vnp_SecureHash') {
                $inputData[$key] = $value;
            }
        }

        // ── RULE 2: Rebuild hash using VNPAY native loop ─────────────────────
        ksort($inputData);
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        // ── STEP 1: EXTRACT BOOKING ID VIA PRECISE REGEX ─────────────────────
        $vnp_TxnRef = $request->get('vnp_TxnRef');
        preg_match('/SONA(\d+)T/', $vnp_TxnRef, $matches);
        $bookingId = $matches[1] ?? null;

        // Early validation: Ensure booking ID was parsed successfully
        if (!$bookingId) {
            Log::error('VNPAY Callback: Failed to extract booking ID from TxnRef', [
                'txn_ref' => $vnp_TxnRef,
                'raw_request' => $request->all()
            ]);

            return redirect()->route('profile.history')
                ->with('error', 'Không thể xác định mã đơn đặt phòng. Vui lòng liên hệ hỗ trợ.');
        }

        // Fetch booking model (will throw 404 if not found)
        $booking = Booking::find($bookingId);

        if (!$booking) {
            Log::error('VNPAY Callback: Booking not found in database', [
                'booking_id' => $bookingId,
                'txn_ref' => $vnp_TxnRef
            ]);

            return redirect()->route('profile.history')
                ->with('error', 'Không tìm thấy đơn đặt phòng. Vui lòng liên hệ hỗ trợ.');
        }

        // ── RULE 2: VALIDATE SIGNATURE ───────────────────────────────────────
        if ($secureHash !== $incomingVnpSecureHash) {
            Log::warning('VNPAY Callback: Invalid Signature Detected', [
                'booking_id' => $bookingId,
                'expected_hash' => $secureHash,
                'received_hash' => $incomingVnpSecureHash,
                'txn_ref' => $vnp_TxnRef,
                'ip_address' => $request->ip()
            ]);

            return redirect()->route('bookings.show', ['booking' => $booking->id])
                ->with('error', 'Chữ ký giao dịch không hợp lệ. Vui lòng liên hệ hỗ trợ nếu bạn vẫn gặp sự cố.');
        }

        // ── RULE 3: PROCESS PAYMENT RESPONSE CODE ────────────────────────────
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');

        // ══════════════════════════════════════════════════════════════════════
        // SUCCESS PATH: Response Code = '00'
        // ══════════════════════════════════════════════════════════════════════
        if ($vnp_ResponseCode === '00') {
            // ── STEP 2: IMPLEMENT MATHEMATICAL DUAL-PAYMENT MATRIX ────────────
            // Extract actual amount paid from VNPAY (convert from cents to VND)
            $vnp_AmountPaid = (float)($request->get('vnp_Amount') / 100);
            $totalMoney = (float)$booking->total_money;

            // Floating-point tolerance: 1.0 VND to eliminate precision issues
            $tolerance = 1.0;

            // Business Logic Matrix:
            // - If amount paid ≈ total_money → Status 2 (Paid 100%)
            // - Otherwise → Status 1 (Deposit Paid 50%)
            if (abs($vnp_AmountPaid - $totalMoney) < $tolerance) {
                $newStatus = Booking::STATUS_PAID; // 2: Paid 100%
                $flashMessage = 'Thanh toán toàn bộ 100% đơn đặt phòng thành công! Cảm ơn quý khách đã tin tưởng Sona Homestay.';
            } else {
                $newStatus = Booking::STATUS_DEPOSIT_PAID; // 1: Paid 50% Deposit
                $flashMessage = 'Thanh toán tiền đặt cọc 50% đơn đặt phòng thành công! Vui lòng thanh toán số tiền còn lại trước khi nhận phòng.';
            }

            // Update booking status in database
            $booking->update(['status' => $newStatus]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'role' => 'Guest',
                'action' => 'Update',
                'target_model' => 'Booking',
                'target_id' => $booking->id,
                'description' => 'Khách ' . Auth::user()->name . ' đã thanh toán ' . ($newStatus === Booking::STATUS_PAID ? '100%' : '50% đặt cọc') . ' cho đơn #' . $booking->id
            ]);

            // ── STEP 3: ENHANCED AUDIT TRAIL LOGGING ──────────────────────────
            Log::info('VNPAY Payment Success Processed', [
                'booking_id' => $booking->id,
                'txn_ref' => $vnp_TxnRef,
                'amount_paid' => $vnp_AmountPaid,
                'total_required' => $totalMoney,
                'assigned_status' => $newStatus,
                'status_label' => $newStatus === Booking::STATUS_PAID ? 'Paid 100%' : 'Deposit 50%',
                'vnp_transaction_no' => $request->get('vnp_TransactionNo'),
                'vnp_bank_code' => $request->get('vnp_BankCode'),
                'vnp_pay_date' => $request->get('vnp_PayDate'),
                'ip_address' => $request->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);

            // ── STEP 4: SAFE REDIRECTION WITH NO PHANTOM VIEWS ───────────────
            return redirect()->route('bookings.show', ['booking' => $booking->id])
                ->with('success', $flashMessage);
        }

        // ══════════════════════════════════════════════════════════════════════
        // FAILURE PATH: Response Code ≠ '00'
        // ══════════════════════════════════════════════════════════════════════

        // Map VNPAY response codes to user-friendly Vietnamese messages
        $errorMessages = [
            '24' => 'Bạn đã hủy giao dịch thanh toán. Vui lòng thử lại nếu bạn vẫn muốn đặt phòng này.',
            '11' => 'Giao dịch đã hết hạn thanh toán. Vui lòng thử lại.',
            '12' => 'Thẻ/Tài khoản bị khóa. Vui lòng liên hệ ngân hàng.',
            '13' => 'Mật khẩu xác thực giao dịch không chính xác. Vui lòng thử lại.',
            '51' => 'Tài khoản không đủ số dư để thanh toán. Vui lòng kiểm tra lại.',
            '65' => 'Tài khoản đã vượt quá hạn mức giao dịch trong ngày.',
            '75' => 'Ngân hàng thanh toán đang bảo trì. Vui lòng thử lại sau.',
            '79' => 'Giao dịch vượt quá số lần nhập sai mật khẩu. Vui lòng thử lại sau 24h.',
        ];

        $errorMessage = $errorMessages[$vnp_ResponseCode] ?? 'Thanh toán không thành công. Mã lỗi: ' . $vnp_ResponseCode . '. Vui lòng thử lại hoặc liên hệ hỗ trợ.';

        // Log payment failure with full context
        Log::warning('VNPAY Payment Failed', [
            'booking_id' => $bookingId,
            'response_code' => $vnp_ResponseCode,
            'txn_ref' => $vnp_TxnRef,
            'error_message' => $errorMessage,
            'vnp_transaction_no' => $request->get('vnp_TransactionNo'),
            'vnp_bank_code' => $request->get('vnp_BankCode'),
            'ip_address' => $request->ip(),
            'timestamp' => now()->toDateTimeString()
        ]);

        // Keep booking status at 0 (Pending) - no status change on failure
        // Redirect to booking detail page with error message
        return redirect()->route('bookings.show', ['booking' => $booking->id])
            ->with('error', $errorMessage);
    }

    /**
     * ⚠️ DEBUG ONLY: Simulate booking timeout for testing room retention logic
     * Forces a booking to expire by backdating its created_at timestamp and marking it as cancelled
     * This allows testing the 1-minute lazy check mechanism without waiting
     * 
     * @param Booking $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function simulateTimeout(Booking $booking)
    {
        // ── SAFETY: Only allow in local/debug environments ────────────────
        if (!app()->environment(['local', 'development']) && !config('app.debug')) {
            abort(403, 'Simulation feature is only available in debug mode.');
        }

        // ── AUTHORIZATION: User must own this booking ─────────────────
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền thao tác với đơn này.');
        }

        // ── RULE: Only pending (status 0) bookings can be simulated ──────────
        if ($booking->status !== Booking::STATUS_PENDING) {
            return redirect()->back()
                ->with('error', 'Chỉ có thể mô phỏng hết hạn với đơn đang chờ thanh toán (status 0).');
        }

        // ── STEP 1: Backdate created_at to 2 minutes ago ───────────────
        $booking->created_at = now()->subMinutes(2);
        $booking->status = Booking::STATUS_CANCELLED;
        $booking->save();

        // ── STEP 2: Room auto-release (already handled by availability logic) ───
        // Your system uses Eloquent-based availability checking via isRoomAvailable()
        // No physical `is_available` column exists - availability is computed dynamically
        // When status changes to CANCELLED, the room automatically becomes available

        Log::info('⚠️ DEBUG: Booking timeout simulated', [
            'booking_id' => $booking->id,
            'room_id' => $booking->room_id,
            'simulated_created_at' => $booking->created_at,
            'new_status' => $booking->status,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()
            ->with('error', '⚠️ [MÔ PHỎNG] Đơn đặt phòng đã hết hạn giữ phòng (1 phút). Phòng đã được thả ra tự động.');
    }
}
