@extends('layouts.master')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Thanh toán thành công</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <span>Hoàn tất</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Success Section Begin -->
    <section class="success-section spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="success-content text-center" style="padding: 50px; background: #f8f9fa; border: 1px solid #ebebeb; border-radius: 5px;">
                        <i class="fa fa-check-circle" style="font-size: 80px; color: #28a745; margin-bottom: 20px;"></i>
                        <h3 style="font-weight: 600; color: #19191a; margin-bottom: 15px;">Cảm ơn quý khách! Đặt phòng thành công.</h3>
                        <p style="font-size: 16px; color: #707079; margin-bottom: 30px;">
                            Chúng tôi đã nhận được thanh toán cọc và xác nhận đơn đặt phòng của quý khách. <br>
                            Mã xác nhận đặt phòng của quý khách là: 
                            <strong style="color: #dfa974; font-size: 18px;">{{ $booking->code ?? 'SONA-000001' }}</strong>
                        </p>
                        <p style="font-size: 15px; color: #707079; margin-bottom: 40px;">
                            Một email xác nhận chi tiết đã được gửi đến địa chỉ email của quý khách. Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua số điện thoại hỗ trợ hoặc email.
                        </p>
                        <a href="{{ route('home') }}" class="primary-btn">Về Trang Chủ</a>
                        <a href="{{ route('profile.history') ?? '#' }}" class="primary-btn" style="background: #19191a; margin-left: 10px;">Xem lịch sử đặt phòng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Success Section End -->
@endsection
