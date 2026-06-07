<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Khách gửi đánh giá chấm sao lên hệ thống
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        // Chỉ cho phép đánh giá nếu đã hoàn thành lưu trú (trả phòng)
        $hasStayed = Booking::where('user_id', Auth::id())
            ->where('room_id', $request->room_id)
            ->where('status', Booking::STATUS_COMPLETED)
            ->exists();

        if (!$hasStayed) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể đánh giá phòng sau khi đã hoàn thành lưu trú và trả phòng!');
        }

        // Lưu đánh giá, mặc định hiển thị, admin có thể ẩn sau
        $review = Review::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => Review::STATUS_VISIBLE
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'role' => 'Guest',
            'action' => 'Create',
            'target_model' => 'Review',
            'target_id' => $review->id,
            'description' => 'Khách ' . Auth::user()->name . ' đã gửi đánh giá ' . $request->rating . ' sao cho phòng (ID #' . $request->room_id . ')'
        ]);

        return redirect()->back()->with('success', 'Cảm ơn cảm nghĩ chân thực của bạn dành cho Sapa Jade Hill!');
    }
}
