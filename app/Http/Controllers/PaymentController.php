<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Payment;

class PaymentController extends Controller
{
    // 1. Khởi tạo giao dịch — tạo link chuyển hướng sang cổng VNPAY
    public function initiate(Booking $booking, Request $request)
    {
        $vnp_TmnCode    = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url        = config('services.vnpay.url');
        $vnp_Returnurl  = route('payment.callback');

        $option = $request->get('option', 'full');
        $amount = ($option === 'deposit')
            ? ($booking->total_money * 0.5)
            : $booking->total_money;

        $vnp_IpAddr = $request->ip();
        if ($vnp_IpAddr === '::1' || !$vnp_IpAddr) {
            $vnp_IpAddr = '127.0.0.1';
        }

        // vnp_TxnRef keeps the _time() suffix to guarantee uniqueness on retry attempts
        $vnp_Data = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => (int) round($amount * 100),
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => "vn",
            "vnp_OrderInfo"  => "Thanh-toan-don-hang-" . $booking->id,
            "vnp_OrderType"  => "other",
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $booking->id . '_' . time(),
            "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes')),
        ];

        // ksort before the loop so both $hashdata and $query are built from identically ordered keys
        ksort($vnp_Data);

        // Official VNPay PHP SDK encoding pattern:
        // rawurlencode() is used — NOT urlencode() — because urlencode() encodes spaces as '+'
        // which corrupts vnp_OrderInfo and vnp_ReturnUrl when the gateway parses the query string.
        // rawurlencode() encodes spaces as '%20', which is safe across all HTTP redirect hops.
        $query    = "";
        $i        = 0;
        $hashdata = "";
        foreach ($vnp_Data as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . rawurlencode($key) . "=" . rawurlencode($value);
            } else {
                $hashdata .= rawurlencode($key) . "=" . rawurlencode($value);
                $i = 1;
            }
            $query .= rawurlencode($key) . "=" . rawurlencode($value) . '&';
        }

        $vnp_Url        = $vnp_Url . "?" . $query;
        $vnpSecureHash  = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url       .= 'vnp_SecureHash=' . $vnpSecureHash;

        Log::info('VNPay URL Generated', [
            'booking_id' => $booking->id,
            'tmn_code'   => $vnp_TmnCode,
            'amount'     => (int) round($amount * 100),
            'url'        => $vnp_Url,
        ]);

        return redirect($vnp_Url);
    }

    // 2. Cổng trả về cho khách hàng sau khi thanh toán tại ngân hàng
    public function callback(Request $request)
    {
        $vnp_HashSecret = config('services.vnpay.hash_secret');

        $inputData     = [];
        $vnpSecureHash = $request->input('vnp_SecureHash', '');

        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'vnp_') && $key !== 'vnp_SecureHash') {
                $inputData[$key] = $value;
            }
        }

        ksort($inputData);
        $i        = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . rawurlencode($key) . "=" . rawurlencode($value);
            } else {
                $hashdata .= rawurlencode($key) . "=" . rawurlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        if (!hash_equals($secureHash, $vnpSecureHash)) {
            return view('bookings.failed', [
                'message' => 'Xác thực giao dịch thất bại. Chữ ký không hợp lệ.',
            ]);
        }

        $orderIdParts = explode('_', $request->input('vnp_TxnRef', ''));
        $bookingId    = $orderIdParts[0] ?? null;

        if ($request->input('vnp_ResponseCode') === '00') {
            $booking = Booking::find($bookingId);
            if ($booking) {
                $booking->update(['status' => Booking::STATUS_PAID]);
            }
            return redirect()->route('bookings.success', ['booking_id' => $bookingId]);
        }

        return view('bookings.failed', [
            'message' => 'Giao dịch thất bại hoặc đã bị quý khách hủy bỏ.',
        ]);
    }

    // 3. Cổng IPN ngầm server-to-server — VNPAY chủ động gọi vào endpoint này
    public function ipn(Request $request)
    {
        try {
            $vnp_HashSecret = config('services.vnpay.hash_secret');

            $inputData     = [];
            $vnpSecureHash = $request->input('vnp_SecureHash', '');

            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'vnp_') && $key !== 'vnp_SecureHash') {
                    $inputData[$key] = $value;
                }
            }

            ksort($inputData);
            $i        = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . rawurlencode($key) . "=" . rawurlencode($value);
                } else {
                    $hashdata .= rawurlencode($key) . "=" . rawurlencode($value);
                    $i = 1;
                }
            }

            $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

            if (!hash_equals($secureHash, $vnpSecureHash)) {
                return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
            }

            $orderIdParts = explode('_', $inputData['vnp_TxnRef'] ?? '');
            $bookingId    = $orderIdParts[0] ?? null;
            $booking      = Booking::find($bookingId);

            if (!$booking) {
                return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
            }

            if (($inputData['vnp_ResponseCode'] ?? '') === '00') {
                $amountPaid = ($inputData['vnp_Amount'] ?? 0) / 100;
                $newStatus  = ($amountPaid < $booking->total_money)
                    ? Booking::STATUS_APPROVED
                    : Booking::STATUS_PAID;

                $booking->update(['status' => $newStatus]);

                Payment::create([
                    'booking_id'         => $booking->id,
                    'vnp_txn_ref'        => $inputData['vnp_TxnRef'],
                    'vnp_transaction_no' => $inputData['vnp_TransactionNo'] ?? '',
                    'vnp_amount'         => $inputData['vnp_Amount'],
                    'vnp_bank_code'      => $inputData['vnp_BankCode'] ?? '',
                    'vnp_response_code'  => $inputData['vnp_ResponseCode'],
                ]);
            } else {
                $booking->update(['status' => Booking::STATUS_CANCELLED]);
            }

            return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);

        } catch (\Exception $e) {
            return response()->json(['RspCode' => '99', 'Message' => 'Uncaught Error']);
        }
    }
}
