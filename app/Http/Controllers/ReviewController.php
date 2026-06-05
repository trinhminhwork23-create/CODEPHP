<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // 1. Trả danh sách lịch sử nghỉ dưỡng cho FE làm trang cá nhân khách hàng
    public function bookingHistory()
    {
        $myBookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('profile.history', compact('myBookings'));
    }

    // 2. Khách gửi đánh giá chấm sao lên hệ thống
    public function storeReview(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        // [XỬ LÝ BẪY LOGIC CHẤT LƯỢNG CAO]: Chỉ cho phép đánh giá nếu đã ở căn phòng này thực tế!
        $hasStayed = Booking::where('user_id', Auth::id())
            ->where('room_id', $request->room_id)
            ->where('status', 'completed') // Trạng thái hoàn thành chuyến đi thực tế của người A
            ->exists();

        if (!$hasStayed) {
            return redirect()->back()->with('error', 'Hệ thống bảo mật chặn: Bạn không thể đánh giá một căn phòng mà bạn chưa từng lưu trú trải nghiệm thực tế!');
        }

        // Lưu đánh giá ở trạng thái hiện mặc định, chờ admin kiểm tra lọc bình luận xấu sau
        Review::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => Review::STATUS_VISIBLE // Thay vì 'is_visible' => 1
        ]);

        return redirect()->back()->with('success', 'Cảm ơn cảm nghĩ chân thực của bạn dành cho Sapa Jade Hill!');
    }
}
