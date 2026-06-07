<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

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

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'role' => Auth::user()->role === 'admin' ? 'Admin' : 'Staff',
            'action' => 'Update',
            'target_model' => 'Review',
            'target_id' => $review->id,
            'description' => Auth::user()->name . ' đã ' . ($review->status == Review::STATUS_VISIBLE ? 'hiển thị' : 'ẩn') . ' đánh giá ID #' . $review->id
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái hiển thị bình luận thành công!');
    }

    // Xóa vĩnh viễn đánh giá khỏi hệ thống
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $reviewId = $review->id;
        $review->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'role' => Auth::user()->role === 'admin' ? 'Admin' : 'Staff',
            'action' => 'Delete',
            'target_model' => 'Review',
            'target_id' => $reviewId,
            'description' => Auth::user()->name . ' đã xóa đánh giá ID #' . $reviewId
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Đã xóa đánh giá vĩnh viễn khỏi hệ thống!');
    }
}
