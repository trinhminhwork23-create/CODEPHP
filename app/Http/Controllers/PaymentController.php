<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // 1. Hàm đóng gói và mã hóa SHA512 tạo link chuyển hướng sang cổng ngân hàng VNPAY
    public function createVnpayPayment(Request $request, $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $option = $request->get('option', 'full'); // Lấy lựa chọn cọc hoặc thanh toán hết

        // Tính số tiền cần thanh toán dựa theo lựa chọn của khách
        $amount = ($option === 'deposit') ? ($booking->total_price * 0.5) : $booking->total_price;

        // Các biến môi trường kéo cấu hình từ file .env bảo mật của bạn
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('payment.vnpay.return');
        $vnp_TmnCode = "XXXXXX"; // Thay mã website kiểm thử VNPAY cấp cho bạn vào đây
        $vnp_HashSecret = "YYYYYYYYYYYYYYYYYYYY"; // Thay chuỗi bí mật mã hóa VNPAY cấp vào đây

        $vnp_TxnRef = $booking->id . '_' . time(); // Mã định danh hóa đơn không trùng lặp
        $vnp_OrderInfo = "Thanh toan don dat phong Sapa Jade Hill #" . $booking->id;
        $vnp_OrderType = "hotel";
        $vnp_Amount = $amount * 100; // VNPAY yêu cầu nhân 100 để triệt tiêu số thập phân
        $vnp_Locale = 'vi';
        $vnp_BankCode = '';
        $vnp_IpAddr = $request->ip();

        $vnp_Data = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => "vn",
            "vnp_OrderInfo"  => "Thanh-toan-don-hang-" . $booking->id,
            "vnp_OrderType"  => "other",
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            "vnp_ExpireDate" => date('YmdHis', strtotime('+10 minutes')), //Thay đổi thời gian hết hạn đơn hàng từ 15 phút thành 10 phút cho đồng bộ FE
        );

        // ksort before the loop so both $hashdata and $query are built from identically ordered keys
        ksort($vnp_Data);

        // Official VNPay PHP SDK encoding pattern: use rawurlencode()
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

        // Cắt bỏ ký tự '&' thừa ở cuối chuỗi $query bằng hàm rtrim trước khi nối với vnp_SecureHash
        $vnp_Url        = $vnp_Url . "?" . rtrim($query, '&');
        $vnpSecureHash  = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url       .= '&vnp_SecureHash=' . $vnpSecureHash; // Thêm dấu & chuẩn vào đây

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
        if ($secureHash !== $vnpSecureHash) {
            return redirect()->route('payment.vnpay.return', array_merge($request->query(), ['vnp_ResponseCode' => '97']));
        }

        return redirect()->route('payment.vnpay.return', $request->query());
    }

    // 2. CỔNG TRẢ VỀ CHO GIAO DIỆN KHÁCH HÀNG (Hiển thị thông báo đẹp đẽ cho FE)
    public function vnpayReturn(Request $request)
    {
        // Cắt chuỗi vnp_TxnRef (VD: "5_1701234567") để lấy ID hóa đơn (số 5)
        $orderIdParts = explode('_', $request->vnp_TxnRef);
        $bookingId = $orderIdParts[0] ?? null;

        if ($request->vnp_ResponseCode == '00') {
            return view('bookings.success', [
                'message' => 'Giao dịch thành công! Chúc quý khách có kỳ nghỉ tuyệt vời tại Sapa Jade Hill.',
                'bookingId' => $bookingId // Truyền biến ID sang View
            ]);
        }
        return view('bookings.failed', ['message' => 'Giao dịch thất bại hoặc đã bị quý khách hủy bỏ.']);
    }

    // 3. [CỨU CÁNH CHẤT LƯỢNG - CỔNG BẢO MẬT IPN NGẦM SERVER-TO-SERVER]
    // Bắt kịch bản khách tắt trình duyệt, mất mạng đột ngột khi vừa thanh toán xong
    public function vnpayIpn(Request $request)
    {
        try {
            $vnp_HashSecret = "YYYYYYYYYYYYYYYYYYYY"; // Giống chuỗi cấu hình bên trên
            $inputData = array();
            foreach ($request->all() as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }

            $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            
            $hashData = "";
            $i = 0;
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            
            // Xác thực chữ ký mã hóa an toàn lõi từ VNPAY gửi sang
            if ($secureHash === $vnpSecureHash) {
                $orderIdParts = explode('_', $inputData['vnp_TxnRef']);
                $bookingId = $orderIdParts[0]; // Tách ID đơn từ chuỗi định danh dạng chuỗi hóa đơn
                
                $booking = Booking::find($bookingId);
                
                if ($booking) {
                    if ($inputData['vnp_ResponseCode'] == '00') {
                    // Cập nhật trạng thái Booking sử dụng hằng số của FE
                    $amountPaid = $inputData['vnp_Amount'] / 100;
                    $newStatus = ($amountPaid < $booking->total_money) ? Booking::STATUS_APPROVED : Booking::STATUS_PAID;
                    $booking->update(['status' => $newStatus]);
                    
                    // Ghi log vào bảng payments chuẩn theo Model của FE
                    Payment::create([
                        'booking_id' => $booking->id,
                        'vnp_txn_ref' => $inputData['vnp_TxnRef'],
                        'vnp_transaction_no' => $inputData['vnp_TransactionNo'],
                        'vnp_amount' => $inputData['vnp_Amount'], // Giữ nguyên số x100 theo chuẩn VNPAY
                        'vnp_bank_code' => $inputData['vnp_BankCode'],
                        'vnp_response_code' => $inputData['vnp_ResponseCode'],
                    ]);
                } else {
                    $booking->update(['status' => Booking::STATUS_CANCELLED]);
                }
                    
                    // Mã phản hồi JSON chuẩn cấu trúc giao tiếp bắt buộc của kỹ sư VNPAY
                    return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
                }
                return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
            }
            return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
        } catch (\Exception $e) {
            return response()->json(['RspCode' => '99', 'Message' => 'Uncaught Error']);
        }
    }
}
