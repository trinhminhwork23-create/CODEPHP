<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController
{
    // Bước 1: Hiển thị form nhập email
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Bước 1: Gửi OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email'    => 'Địa chỉ email không hợp lệ.',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email này chưa được đăng ký trong hệ thống.']);
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $otp, 'created_at' => now()]
        );

        Mail::raw(
            "Mã OTP đặt lại mật khẩu của bạn là: {$otp}\n\nMã có hiệu lực trong 5 phút.\nNếu bạn không yêu cầu, hãy bỏ qua email này.",
            function ($message) use ($request) {
                $message->to($request->email)->subject('Mã OTP đặt lại mật khẩu - Sapa Jade Hill');
            }
        );

        session(['reset_email' => $request->email]);

        return redirect()->route('password.verify.form')
            ->with('status', 'Mã OTP đã được gửi đến email của bạn.');
    }

    // Bước 2: Hiển thị form nhập OTP
    public function showVerifyForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.passwords.verify');
    }

    // Bước 2: Gửi lại OTP
    public function resendOtp()
    {
        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $otp, 'created_at' => now()]
        );

        Mail::raw(
            "Mã OTP đặt lại mật khẩu của bạn là: {$otp}\n\nMã có hiệu lực trong 5 phút.",
            fn($message) => $message->to($email)->subject('Mã OTP đặt lại mật khẩu - Sapa Jade Hill')
        );

        return back()->with('status', 'Mã OTP mới đã được gửi đến email của bạn!');
    }

    // Bước 2: Xác minh OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.digits'   => 'Mã OTP phải bao gồm 6 chữ số.',
        ]);

        $email = session('reset_email');
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || $record->token != $request->otp || Carbon::parse($record->created_at)->diffInMinutes(now()) > 5) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác hoặc đã hết hạn.']);
        }

        session(['otp_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    // Bước 3: Hiển thị form đổi mật khẩu
    public function showResetForm()
    {
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.passwords.reset');
    }

    // Bước 3: Đổi mật khẩu
    public function resetPassword(Request $request)
    {
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required'  => 'Vui lòng nhập mật khẩu mới.',
            'password.min'       => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $email = session('reset_email');

        User::where('email', $email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')
            ->with('status', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại!');
    }
}
