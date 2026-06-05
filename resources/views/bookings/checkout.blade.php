@extends('layouts.master')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Thanh toán</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <a href="{{ route('rooms.index') }}">Phòng nghỉ</a>
                            <span>Thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout-section spad">
        <style>
            .checkout-form input[type="text"],
            .checkout-form input[type="email"],
            .checkout-form textarea {
                width: 100%;
                height: 50px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
                font-size: 16px;
                color: #19191a;
                padding-left: 20px;
                margin-bottom: 25px;
            }
            .checkout-form textarea {
                height: 150px;
                padding-top: 15px;
            }
            .checkout-form label {
                font-size: 16px;
                color: #19191a;
                font-weight: 500;
                margin-bottom: 10px;
                display: block;
            }
            .checkout-order {
                background: #f8f9fa;
                padding: 40px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
            }
            .checkout-order h4 {
                color: #19191a;
                font-weight: 600;
                margin-bottom: 25px;
                border-bottom: 1px solid #ebebeb;
                padding-bottom: 15px;
            }
            .checkout-order ul {
                list-style: none;
                margin-bottom: 25px;
            }
            .checkout-order ul li {
                font-size: 16px;
                color: #707079;
                line-height: 40px;
                display: flex;
                justify-content: space-between;
            }
            .checkout-order ul li span {
                color: #19191a;
                font-weight: 500;
            }
            .checkout-order .checkout-total {
                border-top: 1px solid #ebebeb;
                padding-top: 20px;
                margin-bottom: 25px;
            }
            .checkout-order .checkout-total li {
                font-size: 18px;
                color: #19191a;
                font-weight: 600;
            }
            .checkout-order .checkout-total li span {
                color: #dfa974;
            }
            .vnpay-btn {
                background: #005a9c;
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
            .vnpay-btn:hover {
                background: #00467a;
            }
        </style>
        <div class="container">
            <form action="{{ route('bookings.store') }}" method="POST" class="checkout-form">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id ?? 1 }}">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="checkout-content">
                            <h4 style="margin-bottom: 30px; font-weight: 600;">Thông tin khách hàng</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="name">Họ và tên <span>*</span></label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="email">Địa chỉ Email <span>*</span></label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="phone">Số điện thoại <span>*</span></label>
                                    <input type="text" id="phone" name="phone" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="note">Ghi chú thêm</label>
                                    <textarea id="note" name="comment" placeholder="Yêu cầu đặc biệt..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="checkout-order">
                            <h4>Thông tin đặt phòng</h4>
                            <ul>
                                <li>Phòng <span>{{ $room->name ?? 'Phòng Premium King' }}</span></li>
                                <li>Ngày nhận phòng 
                                    <span>
                                        <input type="date" name="check_in" value="{{ request('check_in', date('Y-m-d')) }}" style="border: none; text-align: right; background: transparent; width: 130px; padding: 0; height: auto;" readonly>
                                    </span>
                                </li>
                                <li>Ngày trả phòng 
                                    <span>
                                        <input type="date" name="check_out" value="{{ request('check_out', date('Y-m-d', strtotime('+1 day'))) }}" style="border: none; text-align: right; background: transparent; width: 130px; padding: 0; height: auto;" readonly>
                                    </span>
                                </li>
                                <li>Người lớn 
                                    <span>
                                        <input type="number" name="adults" value="{{ request('adults', 2) }}" style="border: none; text-align: right; background: transparent; width: 50px; padding: 0; height: auto;" readonly>
                                    </span>
                                </li>
                                <li>Trẻ em 
                                    <span>
                                        <input type="number" name="children" value="{{ request('children', 0) }}" style="border: none; text-align: right; background: transparent; width: 50px; padding: 0; height: auto;" readonly>
                                    </span>
                                </li>
                            </ul>
                            <div class="checkout-total">
                                <ul>
                                    <li>Tổng tiền <span>${{ $room->price ?? 159 }}.00</span></li>
                                    <li>Tiền cọc (50%) <span>${{ ($room->price ?? 159) / 2 }}.00</span></li>
                                </ul>
                            </div>
                            <div class="payment-method">
                                <p style="font-size: 14px; color: #707079; margin-bottom: 20px;">
                                    * Yêu cầu thanh toán cọc 50% qua VNPAY để xác nhận đặt phòng. Số tiền còn lại sẽ được thanh toán khi nhận phòng.
                                </p>
                                <button type="submit" class="vnpay-btn">Thanh toán tiền cọc 50% qua VNPAY</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
