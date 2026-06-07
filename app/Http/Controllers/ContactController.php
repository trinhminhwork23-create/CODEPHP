<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Tiếp nhận văn bản phản hồi và thực hiện trả về thông báo cảm ơn cho Frontend
     */
    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ], [
            'name.required'    => 'Vui lòng nhập đầy đủ họ tên.',
            'email.required'   => 'Vui lòng điền địa chỉ email của bạn.',
            'email.email'      => 'Địa chỉ email cung cấp không đúng định dạng.',
            'message.required' => 'Vui lòng điền nội dung lời nhắn gửi đến resort.',
        ]);

        // Ghi chú: Phần câu lệnh thực tế Insert vào CSDL hoặc gửi Mail SMTP cấu hình bảo mật sẽ do Thành viên 3 thực hiện dựa trên dữ liệu sạch này.
        
        // Trả kết quả thông báo cảm ơn đẹp đẽ hiển thị ra Frontend
        return redirect()->back()->with('success', 'Cảm ơn quý khách đã để lại thông tin liên hệ! Chúng tôi đã ghi nhận và sẽ gửi những chương trình ưu đãi mới nhất qua Email cho bạn sớm nhất.');
    }
}