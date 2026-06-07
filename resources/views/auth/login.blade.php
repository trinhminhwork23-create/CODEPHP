@extends('layouts.master')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Đăng nhập thành viên</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <span>Đăng nhập</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Login Section Begin -->
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
                margin-bottom: 30px;
                text-align: center;
            }
            .login-form input[type="text"],
            .login-form input[type="email"],
            .login-form input[type="password"] {
                width: 100%;
                height: 50px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
                font-size: 16px;
                color: #19191a;
                padding-left: 20px;
                margin-bottom: 25px;
                transition: border-color 0.2s ease, background-color 0.2s ease;
            }
            /* 🛰️ Chrome Autofill State Override — Prevent yellow background flash */
            .login-form input:-webkit-autofill,
            .login-form input:-webkit-autofill:hover,
            .login-form input:-webkit-autofill:focus,
            .login-form input:-webkit-autofill:active {
                -webkit-box-shadow: 0 0 0 30px #f8f9fa inset !important;
                -webkit-text-fill-color: #19191a !important;
                transition: background-color 5000s ease-in-out 0s;
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
            /* Late-login booking notification — Sona resort theme */
            .booking-info-alert {
                background: linear-gradient(135deg, #fff8f0 0%, #fdf1e3 100%);
                border: 1.5px solid #dfa974;
                border-radius: 6px;
                padding: 16px 20px;
                margin-bottom: 28px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }
            .booking-info-alert .alert-icon {
                font-size: 22px;
                color: #dfa974;
                flex-shrink: 0;
                margin-top: 1px;
            }
            .booking-info-alert .alert-body {
                flex: 1;
            }
            .booking-info-alert .alert-title {
                font-size: 14px;
                font-weight: 700;
                color: #c8842a;
                margin-bottom: 4px;
                letter-spacing: 0.3px;
            }
            .booking-info-alert .alert-text {
                font-size: 13.5px;
                color: #7a5c35;
                line-height: 1.5;
                margin: 0;
            }
        </style>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form">
                        <h3>Đăng Nhập</h3>

                        {{-- ── Late Login: thông báo giữ phòng tạm thời ── --}}
                        @if(session('info'))
                            <div class="booking-info-alert">
                                <div class="alert-icon">
                                    <i class="fa fa-calendar-check-o"></i>
                                </div>
                                <div class="alert-body">
                                    <div class="alert-title">Thông tin đặt phòng đã được lưu!</div>
                                    <p class="alert-text">{{ session('info') }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- ── Validation / auth errors ── --}}
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- ── Success flash (e.g. after password reset) ── --}}
                        @if(session('success'))
                            <div class="alert alert-success mb-4">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('auth.login.submit') }}" method="POST" id="login-form" autocomplete="on">
                            @csrf
                            <div>
                                <label for="login_field">Email hoặc Số điện thoại <span>*</span></label>
                                <input 
                                    type="text" 
                                    id="login_field" 
                                    name="login_field"
                                    autocomplete="username"
                                    placeholder="Nhập email hoặc số điện thoại"
                                    required 
                                    value="{{ old('login_field') }}">
                                @error('login_field')
                                    <span class="text-danger small" style="display:block;margin-top:-20px;margin-bottom:15px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="password">Mật khẩu <span>*</span></label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    autocomplete="current-password"
                                    placeholder="Nhập mật khẩu của bạn" 
                                    required>
                                @error('password')
                                    <span class="text-danger small" style="display:block;margin-top:-20px;margin-bottom:15px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top:-10px;">
                                <a href="{{ route('password.request') }}" style="color:#dfa974;font-size:15px;font-weight:500;">Quên mật khẩu?</a>
                            </div>
                            <button type="submit" class="login-btn">Đăng Nhập</button>
                        </form>
                        <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký thành viên ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->

    {{-- 🛰️ CHROME AUTOFILL DETECTION & EVENT SYNCHRONIZATION --}}
    <script>
        (function() {
            'use strict';
            
            // Wait for DOM to be fully ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAutofillHandler);
            } else {
                initAutofillHandler();
            }
            
            function initAutofillHandler() {
                const loginField = document.getElementById('login_field');
                const passwordField = document.getElementById('password');
                
                if (!loginField || !passwordField) return;
                
                // ─── METHOD 1: CSS Animation Start Detection (Most Reliable) ──────
                // Chrome fires 'animationstart' when autofill happens due to :-webkit-autofill pseudo-class
                const detectAutofill = function(e) {
                    if (e.animationName === 'onAutoFillStart') {
                        e.target.setAttribute('data-autofilled', 'true');
                    } else if (e.animationName === 'onAutoFillCancel') {
                        e.target.removeAttribute('data-autofilled');
                    }
                };
                
                // Inject CSS keyframes for autofill detection
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes onAutoFillStart { from { opacity: 0.99; } to { opacity: 1; } }
                    @keyframes onAutoFillCancel { from { opacity: 1; } to { opacity: 0.99; } }
                    input:-webkit-autofill { animation: onAutoFillStart 0s forwards; }
                    input:not(:-webkit-autofill) { animation: onAutoFillCancel 0s forwards; }
                `;
                document.head.appendChild(style);
                
                loginField.addEventListener('animationstart', detectAutofill, true);
                passwordField.addEventListener('animationstart', detectAutofill, true);
                
                // ─── METHOD 2: Input Event Listener for Manual + Autofill Changes ─────
                // Handles both Chrome quick-switch and manual typing
                const syncInputState = function(e) {
                    const input = e.target;
                    
                    // Check if input has value (either autofilled or manually typed)
                    if (input.value && input.value.trim() !== '') {
                        input.classList.add('has-value');
                    } else {
                        input.classList.remove('has-value');
                    }
                };
                
                // Listen to multiple events to catch all state changes
                ['input', 'change', 'blur', 'focus'].forEach(function(eventType) {
                    loginField.addEventListener(eventType, syncInputState);
                    passwordField.addEventListener(eventType, syncInputState);
                });
                
                // ─── METHOD 3: Immediate State Check on Page Load ──────────────
                // Catch pre-filled values from browser's "Back" navigation or session restore
                setTimeout(function() {
                    [loginField, passwordField].forEach(function(input) {
                        if (input.value && input.value.trim() !== '') {
                            input.classList.add('has-value');
                            input.setAttribute('data-autofilled', 'true');
                        }
                    });
                }, 100);
                
                // ─── METHOD 4: MutationObserver for Chrome Account Switcher ───────
                // Watches for Chrome's internal value changes when user switches accounts from dropdown
                const observeValueChanges = function(input) {
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.type === 'attributes' && mutation.attributeName === 'value') {
                                syncInputState({ target: input });
                            }
                        });
                    });
                    
                    observer.observe(input, {
                        attributes: true,
                        attributeFilter: ['value']
                    });
                };
                
                observeValueChanges(loginField);
                observeValueChanges(passwordField);
                
                // ─── DEBUGGING (Remove in production) ───────────────────
                // Uncomment to log autofill events in console
                // loginField.addEventListener('input', function() {
                //     console.log('[AUTOFILL DEBUG] Login field changed:', this.value);
                // });
            }
        })();
    </script>
@endsection
