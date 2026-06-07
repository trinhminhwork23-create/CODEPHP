@extends('layouts.master')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Chi tiết đơn đặt phòng</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <a href="{{ route('profile.history') }}">Lịch sử đặt phòng</a>
                            <span>Chi tiết</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Booking Detail Section Begin -->
    <section class="booking-detail-section spad">
        <style>
            .booking-detail-card {
                border: 1px solid #ebebeb;
                border-radius: 2px;
                background: #ffffff;
                box-shadow: 0 2px 8px rgba(0,0,0,0.02);
                padding: 30px;
                margin-bottom: 30px;
            }
            .booking-detail-card h4 {
                font-weight: 600;
                color: #19191a;
                border-left: 4px solid #dfa974;
                padding-left: 10px;
                margin-bottom: 25px;
            }
            .detail-row {
                display: flex;
                justify-content: space-between;
                padding: 15px 0;
                border-bottom: 1px solid #f0f0f0;
            }
            .detail-row:last-child {
                border-bottom: none;
            }
            .detail-label {
                font-weight: 600;
                color: #707079;
                font-size: 15px;
            }
            .detail-value {
                font-weight: 500;
                color: #19191a;
                font-size: 15px;
                text-align: right;
            }
            .detail-value.price {
                color: #dfa974;
                font-weight: 700;
                font-size: 18px;
            }
        </style>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 2px; font-weight: 500;">
                            <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 2px; font-weight: 500;">
                            <i class="fa fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <!-- Booking Information Card -->
                    <div class="booking-detail-card">
                        <h4>Thông tin đơn đặt phòng</h4>

                        <div class="detail-row">
                            <span class="detail-label">Mã đơn hàng:</span>
                            <span class="detail-value">SJD-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Trạng thái:</span>
                            <span class="detail-value">
                                @switch($booking->status)
                                    @case(\App\Models\Booking::STATUS_PENDING)
                                        <span class="badge" style="background-color: #dc3545; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                            <i class="fa fa-exclamation-circle mr-1"></i> Chờ thanh toán
                                        </span>
                                        @break
                                    @case(\App\Models\Booking::STATUS_DEPOSIT_PAID)
                                        <span class="badge" style="background-color: #f39c12; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                            <i class="fa fa-check-circle mr-1"></i> Đã cọc 50%
                                        </span>
                                        @break
                                    @case(\App\Models\Booking::STATUS_PAID)
                                        <span class="badge" style="background-color: #28a745; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                            <i class="fa fa-check-circle-o mr-1"></i> Đã thanh toán 100%
                                        </span>
                                        @break
                                    @case(\App\Models\Booking::STATUS_CANCELLED)
                                        <span class="badge" style="background-color: #6c757d; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                            <i class="fa fa-ban mr-1"></i> Đã hủy
                                        </span>
                                        @break
                                @endswitch
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Tên phòng:</span>
                            <span class="detail-value">{{ $booking->room->name ?? 'N/A' }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Loại phòng:</span>
                            <span class="detail-value">{{ $booking->room->category->name ?? 'N/A' }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Ngày nhận phòng:</span>
                            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Ngày trả phòng:</span>
                            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Số đêm:</span>
                            <span class="detail-value">
                                {{ max(1, \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out))) }} đêm
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Số người lớn:</span>
                            <span class="detail-value">{{ $booking->adults ?? 1 }} người</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Số trẻ em:</span>
                            <span class="detail-value">{{ $booking->children ?? 0 }} trẻ</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Tổng tiền:</span>
                            <span class="detail-value price">{{ number_format($booking->total_money, 0, ',', '.') }}₫</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Ngày đặt:</span>
                            <span class="detail-value">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <!-- Payment Actions Card -->
                    <div class="booking-detail-card">
                        <h4>Thao tác</h4>

                        {{-- ⏱️ COUNTDOWN TIMER: Only visible for pending bookings (status 0) --}}
                        @if($booking->status == \App\Models\Booking::STATUS_PENDING)
                            <div id="countdown-container" class="alert alert-warning" style="background-color: #fff3cd; border-color: #ffeeba; color: #856404; border-radius: 2px; margin-bottom: 20px; font-size: 15px;">
                                <i class="fa fa-clock-o mr-2"></i>
                                <strong>Thời gian giữ phòng còn lại:</strong> 
                                <span id="countdown-timer" style="font-weight: 700; font-size: 18px; color: #dc3545;">01:00</span>
                                <div style="margin-top: 8px; font-size: 13px; color: #856404;">
                                    Vui lòng thanh toán trong thời gian quy định. Sau khi hết hạn, phòng sẽ tự động được thả ra.
                                </div>
                            </div>

                            <div id="expired-message" class="alert alert-danger" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; border-radius: 2px; margin-bottom: 20px; display: none;">
                                <i class="fa fa-exclamation-triangle mr-2"></i>
                                <strong>Hết thời gian giữ phòng!</strong> Đơn đặt phòng đã hết hạn. Phòng đã được thả ra tự động. Trang sẽ tự động tải lại...
                            </div>
                        @endif

                        @if($booking->status == \App\Models\Booking::STATUS_PENDING)
                            {{-- Status 0: Chờ thanh toán --}}
                            <div id="payment-actions-container" class="alert alert-warning" style="background-color: #fff3cd; border-color: #ffeeba; color: #856404; border-radius: 2px; margin-bottom: 20px;">
                                <i class="fa fa-exclamation-triangle mr-2"></i>
                                <strong>Vui lòng thanh toán để hoàn tất đặt phòng.</strong> Bạn có thể chọn thanh toán 100% hoặc đặt cọc 50%.
                            </div>

                            <div id="payment-buttons" style="display: flex; flex-direction: column; gap: 12px; align-items: center; max-width: 400px; margin: 0 auto;">
                                {{-- Green Button: Pay 100% --}}
                                <a href="{{ route('payment.initiate', ['booking' => $booking->id, 'option' => 'full']) }}" 
                                   style="display: block; width: 100%; padding: 14px 35px; font-size: 15px; font-weight: 700; text-align: center; background-color: #28a745; border: none; border-radius: 3px; color: #ffffff; text-decoration: none; transition: opacity 0.3s;" 
                                   onmouseover="this.style.opacity='0.85'" 
                                   onmouseout="this.style.opacity='1'">
                                    <i class="fa fa-credit-card" style="margin-right: 8px;"></i> THANH TOÁN NGAY (100%)
                                </a>
                                
                                {{-- Orange Button: Pay 50% Deposit --}}
                                <a href="{{ route('payment.initiate', ['booking' => $booking->id, 'option' => 'deposit']) }}" 
                                   style="display: block; width: 100%; padding: 14px 35px; font-size: 15px; font-weight: 700; text-align: center; background-color: #ff9800; border: none; border-radius: 3px; color: #ffffff; text-decoration: none; transition: opacity 0.3s;" 
                                   onmouseover="this.style.opacity='0.85'" 
                                   onmouseout="this.style.opacity='1'">
                                    <i class="fa fa-credit-card-alt" style="margin-right: 8px;"></i> ĐẶT CỌC 50%
                                </a>
                                
                                {{-- Red Button: Cancel --}}
                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="margin: 0; width: 100%;" onsubmit="return confirm('Bạn có chắc muốn hủy đơn đặt phòng này?')">
                                    @csrf
                                    <button type="submit" 
                                            style="width: 100%; padding: 14px 35px; font-size: 15px; font-weight: 700; text-align: center; background-color: #dc3545; border: none; border-radius: 3px; color: #ffffff; cursor: pointer; transition: opacity 0.3s;" 
                                            onmouseover="this.style.opacity='0.85'" 
                                            onmouseout="this.style.opacity='1'">
                                        <i class="fa fa-times-circle" style="margin-right: 8px;"></i> HỦY ĐƠN ĐẶT PHÒNG
                                    </button>
                                </form>
                            </div>

                            {{-- ⚠️ DEBUG ONLY: Simulation Button (only in local/debug) --}}
                            @if(app()->environment(['local', 'development']) || config('app.debug'))
                                <div style="border-top: 2px dashed #ddd; margin-top: 30px; padding-top: 20px;">
                                    <div class="alert" style="background-color: #e7f3ff; border: 1px solid #b3d7ff; color: #004085; border-radius: 2px; margin-bottom: 15px; font-size: 13px;">
                                        <i class="fa fa-flask mr-2"></i>
                                        <strong>Chế độ Debug:</strong> Nút dưới đây cho phép mô phỏng hết hạn giữ phòng ngay lập tức (không cần chờ 1 phút).
                                    </div>
                                    <form action="{{ route('bookings.simulateTimeout', $booking->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('⚠️ Bạn có chắc muốn kích hoạt mô phỏng hết hạn? Đơn sẽ chuyển sang trạng thái \'Hủy\' ngay lập tức.')">
                                        @csrf
                                        <button type="submit" 
                                                style="width: 100%; max-width: 400px; margin: 0 auto; display: block; padding: 12px 30px; font-size: 14px; font-weight: 600; text-align: center; background-color: #6c757d; border: none; border-radius: 3px; color: #ffffff; cursor: pointer; transition: opacity 0.3s;" 
                                                onmouseover="this.style.opacity='0.85'" 
                                                onmouseout="this.style.opacity='1'">
                                            <i class="fa fa-flask" style="margin-right: 6px;"></i> ⚙️ Kích hoạt: Thời gian mô phỏng (Hết hạn giữ phòng)
                                        </button>
                                    </form>
                                </div>
                            @endif

                        @elseif($booking->status == \App\Models\Booking::STATUS_DEPOSIT_PAID)
                            {{-- Status 1: Đã cọc 50% --}}
                            <div class="alert alert-info" style="background-color: #d1ecf1; border-color: #bee5eb; color: #0c5460; border-radius: 2px; margin-bottom: 20px;">
                                <i class="fa fa-info-circle mr-2"></i>
                                <strong>Bạn đã đặt cọc 50%.</strong> Vui lòng thanh toán số tiền còn lại để hoàn tất đơn đặt phòng.
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 12px; align-items: center; max-width: 400px; margin: 0 auto;">
                                {{-- Blue Button: Pay Remaining 50% --}}
                                <a href="{{ route('payment.initiate', ['booking' => $booking->id, 'option' => 'deposit']) }}" 
                                   style="display: block; width: 100%; padding: 14px 35px; font-size: 15px; font-weight: 700; text-align: center; background-color: #007bff; border: none; border-radius: 3px; color: #ffffff; text-decoration: none; transition: opacity 0.3s;" 
                                   onmouseover="this.style.opacity='0.85'" 
                                   onmouseout="this.style.opacity='1'">
                                    <i class="fa fa-credit-card" style="margin-right: 8px;"></i> THANH TOÁN 50% CÒN LẠI
                                </a>
                                
                                {{-- Red Button: Cancel --}}
                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="margin: 0; width: 100%;" onsubmit="return confirm('Bạn có chắc muốn hủy đơn đặt phòng này? Tiền cọc có thể không được hoàn trả.')">
                                    @csrf
                                    <button type="submit" 
                                            style="width: 100%; padding: 14px 35px; font-size: 15px; font-weight: 700; text-align: center; background-color: #dc3545; border: none; border-radius: 3px; color: #ffffff; cursor: pointer; transition: opacity 0.3s;" 
                                            onmouseover="this.style.opacity='0.85'" 
                                            onmouseout="this.style.opacity='1'">
                                        <i class="fa fa-times-circle" style="margin-right: 8px;"></i> HỦY ĐƠN ĐẶT PHÒNG
                                    </button>
                                </form>
                            </div>

                        @elseif($booking->status == \App\Models\Booking::STATUS_PAID)
                            {{-- Status 2: Đã thanh toán 100% --}}
                            <div class="alert alert-success" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; border-radius: 2px; margin-bottom: 20px;">
                                <i class="fa fa-check-circle mr-2"></i>
                                <strong>Hoàn tất!</strong> Bạn đã thanh toán đầy đủ cho đơn đặt phòng này. Cảm ơn quý khách đã tin tưởng!
                            </div>

                            <div style="display: flex; justify-content: center; max-width: 400px; margin: 0 auto;">
                                {{-- Gold Border Button: Review --}}
                                <a href="{{ route('rooms.show', $booking->room_id) }}#reviews" 
                                   style="display: block; width: 100%; padding: 13px 35px; font-size: 15px; font-weight: 600; text-align: center; background-color: transparent; border: 2px solid #dfa974; border-radius: 3px; color: #dfa974; text-decoration: none; transition: all 0.3s;" 
                                   onmouseover="this.style.backgroundColor='#dfa974'; this.style.color='#ffffff'" 
                                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dfa974'">
                                    <i class="fa fa-star-o" style="margin-right: 8px;"></i> ĐÁNH GIÁ TRẢI NGHIỆM
                                </a>
                            </div>

                        @elseif($booking->status == \App\Models\Booking::STATUS_CANCELLED)
                            {{-- Status 3: Đã hủy --}}
                            <div class="alert alert-secondary" style="background-color: #e2e3e5; border-color: #d6d8db; color: #383d41; border-radius: 2px;">
                                <i class="fa fa-ban mr-2"></i>
                                <strong>Đã hủy.</strong> Đơn đặt phòng này đã bị hủy.
                            </div>
                        @endif

                        <div class="text-center mt-4">
                            <a href="{{ route('profile.history') }}" class="btn btn-outline-secondary" style="padding: 12px 30px; font-size: 14px; border-radius: 2px; border-color: #6c757d; color: #6c757d;">
                                <i class="fa fa-arrow-left mr-2"></i> Quay lại lịch sử đặt phòng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Booking Detail Section End -->

    {{-- ⏱️ COUNTDOWN TIMER JAVASCRIPT --}}
    @if($booking->status == \App\Models\Booking::STATUS_PENDING)
        <script>
            (function() {
                // Extract booking created_at timestamp from PHP
                const bookingCreatedAt = new Date('{{ $booking->created_at->toIso8601String() }}');
                const expirationTimeMs = 60 * 1000; // 1 minute in milliseconds
                const expirationTimestamp = bookingCreatedAt.getTime() + expirationTimeMs;

                const countdownElement = document.getElementById('countdown-timer');
                const countdownContainer = document.getElementById('countdown-container');
                const expiredMessage = document.getElementById('expired-message');
                const paymentButtons = document.getElementById('payment-buttons');
                const paymentActionsContainer = document.getElementById('payment-actions-container');

                function updateCountdown() {
                    const now = Date.now();
                    const remainingMs = expirationTimestamp - now;

                    if (remainingMs <= 0) {
                        // Timer expired
                        countdownElement.textContent = '00:00';
                        countdownElement.style.color = '#dc3545';
                        
                        // Hide countdown and payment buttons
                        if (countdownContainer) countdownContainer.style.display = 'none';
                        if (paymentActionsContainer) paymentActionsContainer.style.display = 'none';
                        if (paymentButtons) paymentButtons.style.display = 'none';
                        
                        // Show expiration message
                        if (expiredMessage) expiredMessage.style.display = 'block';

                        // Auto-reload page after 3 seconds to trigger backend lazy check
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);

                        clearInterval(timerInterval);
                        return;
                    }

                    // Calculate minutes and seconds
                    const totalSeconds = Math.floor(remainingMs / 1000);
                    const minutes = Math.floor(totalSeconds / 60);
                    const seconds = totalSeconds % 60;

                    // Format as MM:SS
                    const formattedTime = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
                    countdownElement.textContent = formattedTime;

                    // Change color to red when less than 30 seconds
                    if (remainingMs < 30000) {
                        countdownElement.style.color = '#dc3545';
                        if (countdownContainer) {
                            countdownContainer.style.backgroundColor = '#f8d7da';
                            countdownContainer.style.borderColor = '#f5c6cb';
                            countdownContainer.style.color = '#721c24';
                        }
                    }
                }

                // Update immediately
                updateCountdown();

                // Update every second
                const timerInterval = setInterval(updateCountdown, 1000);
            })();
        </script>
    @endif
@endsection
