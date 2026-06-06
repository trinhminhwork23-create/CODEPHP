<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class AdminReviewController extends Controller
{
    // Hiển thị toàn diện kho đánh giá cho quản trị viên xem xét
    public function index()
    {
        $reviews = Review::with(['user', 'room'])->orderBy('created_at', 'DESC')->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    // Nút bấm giúp Admin ẩn bình luận xấu hoặc kích hoạt hiển thị lại
    public function toggleVisibility($id)
    {
        $review = Review::findOrFail($id);
        
        // Đảo trạng thái sử dụng hằng số
        $review->status = ($review->status == Review::STATUS_VISIBLE) 
                          ? Review::STATUS_HIDDEN 
                          : Review::STATUS_VISIBLE;
        $review->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái hiển thị bình luận thành công!');
    }

    // Xóa vĩnh viễn đánh giá khỏi hệ thống
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đã xóa đánh giá vĩnh viễn khỏi hệ thống!');
    }
}
