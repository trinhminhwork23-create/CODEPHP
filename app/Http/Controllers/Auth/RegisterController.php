<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'required|numeric|digits_between:10,15|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'        => 'Vui lòng nhập họ và tên.',
            'name.string'          => 'Họ và tên phải là chuỗi ký tự.',
            'name.max'             => 'Họ và tên không được vượt quá 255 ký tự.',
            'email.required'       => 'Vui lòng nhập địa chỉ email.',
            'email.email'          => 'Địa chỉ email không hợp lệ.',
            'email.max'            => 'Địa chỉ email không được vượt quá 255 ký tự.',
            'email.unique'         => 'Địa chỉ email này đã được sử dụng.',
            'phone.required'       => 'Vui lòng nhập số điện thoại.',
            'phone.numeric'        => 'Số điện thoại chỉ được chứa chữ số.',
            'phone.digits_between' => 'Số điện thoại phải có từ 10 đến 15 chữ số.',
            'phone.unique'         => 'Số điện thoại này đã được sử dụng.',
            'password.required'    => 'Vui lòng nhập mật khẩu.',
            'password.string'      => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min'         => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed'   => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
            'status'   => 1,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công! Chào mừng bạn đến với Sapa Jade Hill.');
    }
}
