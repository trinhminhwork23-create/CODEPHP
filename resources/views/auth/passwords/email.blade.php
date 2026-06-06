@extends('layouts.master')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Khôi phục mật khẩu</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <span>Quên mật khẩu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Password Recovery Section Begin -->
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
            .login-form input[type="email"] {
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
            .login-btn:hover {
                background: #c69463;
            }
            .login-form p {
                text-align: center;
                margin-top: 25px;
                font-size: 15px;
                color: #707079;
                margin-bottom: 0;
            }
            .login-form p a {
                color: #dfa974;
                font-weight: 500;
            }
        </style>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form">
                        <h3>Quên mật khẩu?</h3>
                        <p class="text-center mb-4" style="font-size: 14px;">Vui lòng điền địa chỉ email đăng ký tài khoản của bạn để nhận liên kết khôi phục mật khẩu.</p>
                        
                        @if (session('status'))
                            <div class="alert alert-success mb-4 text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div>
                                <label for="email">Địa chỉ Email <span>*</span></label>
                                <input type="email" id="email" name="email" placeholder="Nhập địa chỉ email đăng ký" required value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger small" style="display: block; margin-top: 5px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="login-btn">Gửi liên kết khôi phục</button>
                        </form>
                        <p><a href="{{ route('login') }}">Quay lại trang Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Password Recovery Section End -->
@endsection
