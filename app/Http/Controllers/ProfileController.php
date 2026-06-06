<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;

class ProfileController extends Controller
{
    /**
     * Show unified account dashboard with booking records.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('room')->latest()->get();

        return view('profile.history', compact('bookings'));
    }

    /**
     * Update user details (name and phone).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ], [
            'name.required'  => 'Vui lòng nhập họ và tên.',
            'name.string'    => 'Họ và tên phải là chuỗi ký tự.',
            'name.max'       => 'Họ và tên không được quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.max'      => 'Số điện thoại không được quá 20 ký tự.',
        ]);

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Cập nhật thông tin cá nhân thành công.');
    }

    /**
     * Verify current password and hash new password safely.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required'         => 'Vui lòng nhập mật khẩu mới.',
            'password.string'           => 'Mật khẩu mới phải là chuỗi ký tự.',
            'password.min'              => 'Mật khẩu mới phải từ 6 ký tự trở lên.',
            'password.confirmed'        => 'Xác nhận mật khẩu mới không trùng khớp.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công.');
    }
}
