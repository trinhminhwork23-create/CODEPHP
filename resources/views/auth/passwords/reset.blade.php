@extends('layouts.master')

@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Đặt lại mật khẩu</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <span>Đặt lại mật khẩu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="login-section spad">
        <style>
            .login-form {
                background: #f8f9fa;
                padding: 50px;
                border: 1px solid #ebebeb;
                border-radius: 5px;
            }
            .login-form h3 {
                color: #19191a;
                font-weight: 600;
                margin-bottom: 20px;
                text-align: center;
            }
            .login-form input[type="password"] {
                width: 100%;
                height: 50px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
                font-size: 16px;
                color: #19191a;
                padding-left: 20px;
                margin-bottom: 5px;
            }
            .login-form label {
                font-size: 16px;
                color: #19191a;
                font-weight: 500;
                margin-bottom: 10px;
                display: block;
            }
            .login-btn {
                background: #dfa974;
                color: #ffffff;
                font-size: 16px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 2px;
                width: 100%;
                border: none;
                padding: 14px 0 12px;
                border-radius: 2px;
                cursor: pointer;
                transition: all 0.3s;
                margin-top: 15px;
            }
            .login-btn:hover { background: #c69463; }
            .login-form p {
                text-align: center;
                margin-top: 25px;
                font-size: 15px;
                color: #707079;
                margin-bottom: 0;
            }
            .login-form p a { color: #dfa974; font-weight: 500; }
        </style>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form">
                        <h3>Đặt mật khẩu mới</h3>

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul style="margin:0;padding-left:20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div>
                                <label for="password">Mật khẩu mới <span>*</span></label>
                                <input type="password" id="password" name="password"
                                    placeholder="Tối thiểu 8 ký tự" required>
                                @error('password')
                                    <span class="text-danger small" style="display:block;margin-top:5px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="margin-top:20px;">
                                <label for="password_confirmation">Xác nhận mật khẩu <span>*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Nhập lại mật khẩu mới" required>
                            </div>
                            <button type="submit" class="login-btn">Đổi mật khẩu</button>
                        </form>
                        <p><a href="{{ route('login') }}">Quay lại Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
