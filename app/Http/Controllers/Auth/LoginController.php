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
                ->withErrors(['login_field' => 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ quản trị viên.']);
        }

        // Kiểm tra is_locked - Hệ thống Audit mới
        if ($user->is_locked) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $lockReason = $user->lock_reason ?? 'Không có lý do được ghi nhận.';
            return redirect()->route('login')
                ->withErrors(['login_field' => 'Tài khoản của bạn đã bị khóa! Lý do: ' . $lockReason]);
        }

        // ── CRITICAL: Read pending_booking BEFORE regenerate() ───────────────
        // session()->regenerate() migrates the session to a new ID. On file-based
        // session drivers, data is reliably carried over, but reading BEFORE the
        // migration removes any timing ambiguity entirely.
        $pendingBooking = $request->session()->get('pending_booking');

        // Regenerate session ID to prevent session fixation attacks
        $request->session()->regenerate();

        // ── Late Login restore (UC Đặt phòng nhanh - Luồng phụ 1) ────────────
        // If the guest had selected a room before being redirected to login,
        // restore their booking intent and send them directly to checkout.
        if (!empty($pendingBooking) && !empty($pendingBooking['room_id'])) {
            // 🛡️ DEFENSIVE CHECK: Validate room still exists before redirecting
            // Prevents 404 error from stale session data when room was deleted
            $roomExists = \App\Models\Room::where('id', $pendingBooking['room_id'])->exists();
            
            if ($roomExists) {
                return redirect()->route('bookings.checkout', [
                    'room'      => $pendingBooking['room_id'],
                    'check_in'  => $pendingBooking['check_in']  ?? '',
                    'check_out' => $pendingBooking['check_out'] ?? '',
                    'adults'    => $pendingBooking['adults']    ?? 1,
                    'children'  => $pendingBooking['children']  ?? 0,
                ])->with('success', 'Đăng nhập thành công! Đơn đặt phòng của bạn đã được khôi phục.');
            } else {
                // Room was deleted/unavailable — clear stale session & proceed normally
                $request->session()->forget('pending_booking');
            }
        }

        // ── Default post-login redirect ───────────────────────────────────────
        if (in_array($user->role, ['admin', 'staff'])) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
