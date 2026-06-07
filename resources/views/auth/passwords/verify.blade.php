@extends('layouts.master')

@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Xác nhận OTP</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <span>Xác nhận OTP</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="login-section spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form">
                        <h3>Nhập mã OTP</h3>
                        <p class="text-center mb-4" style="font-size:14px;">
                            Mã OTP đã được gửi đến <strong>{{ session('reset_email') }}</strong>
                        </p>

                        @if (session('status'))
                            <div class="alert alert-success mb-4 text-center">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('password.verify') }}">
                            @csrf
                            <div>
                                <label for="email">Địa chỉ Email</label>
                                <input type="email" value="{{ session('reset_email') }}" readonly
                                    style="width:100%;height:50px;border:1px solid #ebebeb;padding-left:20px;background:#e9ecef;font-size:16px;">
                            </div>
                            <div style="margin-top:20px;">
                                <label for="otp">Mã OTP <span>*</span></label>
                                <input type="text" id="otp" name="otp" placeholder="Nhập mã 6 số"
                                    maxlength="6" required value="{{ old('otp') }}"
                                    style="width:100%;height:50px;border:1px solid #ebebeb;padding-left:20px;font-size:16px;">
                                @error('otp')
                                    <span class="text-danger small" style="display:block;margin-top:5px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="login-btn" style="margin-top:20px;">Xác nhận OTP</button>
                        </form>
                        <p style="text-align:center;margin-top:20px;">
                        <form method="POST" action="{{ route('password.resend') }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:none;border:none;color:#dfa974;font-weight:500;cursor:pointer;padding:0;font-size:inherit;">Gửi lại mã OTP</button>
                            </form>
                            &nbsp;|&nbsp;
                            <a href="{{ route('login') }}" style="color:#dfa974;">Quay lại Đăng nhập</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
