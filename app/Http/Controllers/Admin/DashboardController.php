<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Thống kê cơ bản
        $totalRevenue = Payment::where('vnp_response_code', '00')->sum('vnp_amount') / 100;
        $totalBookings = Booking::count();
        $totalRooms = Room::count();
        $totalCustomers = User::where('role', 'customer')->count(); // Giả định có cột role
        
        // 2. Thống kê trạng thái
        $pendingBookings = Booking::where('status', Booking::STATUS_PENDING)->count();
        $cancelledBookings = Booking::where('status', Booking::STATUS_CANCELLED)->count();
        $totalReviews = Review::count();

        // 3. Khách hàng
        $newCustomers = User::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $returningCustomers = User::has('bookings', '>', 1)->count();

        // 4. List hiển thị
        $topRooms = Room::withCount(['bookings' => fn($q) => $q->where('status', Booking::STATUS_PAID)])->orderBy('bookings_count', 'desc')->take(5)->get();
        $latestReviews = Review::with(['user', 'room'])->latest()->take(5)->get();
        $latestBookings = Booking::with(['user', 'room'])->latest()->take(5)->get();

        // 5. Logic Chart Doanh thu (Code của bạn đã làm rất tốt)
        $monthlyRevenueData = Payment::where('vnp_response_code', '00')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('(SUM(vnp_amount) / 100) as revenue'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')->orderBy('month', 'ASC')->get();

        $chartMonths = []; $chartDataValues = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartMonths[] = "Tháng " . $m;
            $found = $monthlyRevenueData->firstWhere('month', $m);
            $chartDataValues[] = $found ? $found->revenue : 0;
        }

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalBookings', 'totalRooms', 'totalCustomers',
            'pendingBookings', 'cancelledBookings', 'totalReviews',
            'newCustomers', 'returningCustomers', 'topRooms', 'latestReviews', 
            'latestBookings', 'chartMonths', 'chartDataValues'
        ));
    }
}
