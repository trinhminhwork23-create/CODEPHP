<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_field' => 'required',
            'password'    => 'required',
        ], [
            'login_field.required' => 'Vui lòng nhập email hoặc số điện thoại.',
            'password.required'    => 'Vui lòng nhập mật khẩu.',
        ]);

        $loginField = $request->input('login_field');
        $column     = str_contains($loginField, '@') ? 'email' : 'phone';

        $user = User::where($column, $loginField)->first();

        if (!$user || !Auth::attempt([$column => $loginField, 'password' => $request->password])) {
            return back()
                ->withInput($request->only('login_field'))
                ->withErrors(['login_field' => 'Thông tin đăng nhập không chính xác!']);
        }

        $user = Auth::user();

        if ($user->isBanned()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['login_field' => 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ quản trị viên']);
        }

        // VẤN ĐỀ 2: Lưu lại mảng dữ liệu chọn phòng từ session cũ trước khi regenerate để tránh mất mát dữ liệu
        $lateLoginBooking = $request->session()->get('late_login_booking');

        $request->session()->regenerate();

        // Nếu phát hiện khách đang ở trong luồng Đặt phòng nhanh dở dang
        if ($lateLoginBooking) {
            // Nạp lại mảng thông tin vào Session mới
            $request->session()->put('late_login_booking', $lateLoginBooking);
            
            if (!in_array($user->role, ['admin', 'staff'])) {
                // Tự động khôi phục dữ liệu điều hướng thẳng sang trang Checkout thay vì đưa về trang chủ
                return redirect()->route('bookings.checkout', [
                    'room'      => $lateLoginBooking['room_id'],
                    'check_in'  => $lateLoginBooking['check_in'],
                    'check_out' => $lateLoginBooking['check_out'],
                    'adults'    => $lateLoginBooking['adults'],
                    'children'  => $lateLoginBooking['children'],
                ]);
            }
        }

        if (in_array($user->role, ['admin', 'staff'])) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
