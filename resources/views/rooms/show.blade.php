@extends('layouts.master')

@section('content')

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Phòng nghỉ của chúng tôi</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <a href="{{ route('rooms.index') }}">Phòng nghỉ</a>
                            <span>{{ $room->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Room Details Section Begin -->
    <section class="room-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="room-details-item">
                        <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1200&q=80' }}"
                             alt="{{ $room->name }}">
                        <div class="rd-text">
                            <div class="rd-title">
                                <h3>{{ $room->name }}</h3>
                                <div class="rdt-right">
                                    {{-- Dynamic star rating from avg --}}
                                    <div class="rating">
                                        @php $avg = round($avgRating ?? 0); @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $avg)
                                                <i class="icon_star"></i>
                                            @else
                                                <i class="icon_star" style="opacity:0.3"></i>
                                            @endif
                                        @endfor
                                        @if($avgRating)
                                            <small>({{ number_format($avgRating, 1) }}/5 — {{ $room->reviews->count() }} đánh giá)</small>
                                        @endif
                                    </div>
                                    <a href="#booking-form">Đặt phòng ngay</a>
                                </div>
                            </div>
                            <h2>{{ number_format($room->price, 0, ',', '.') }}<span> đ/Đêm</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Mã phòng:</td>
                                        <td>{{ $room->room_code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Diện tích:</td>
                                        <td>{{ $room->size ? $room->size . ' m²' : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Sức chứa:</td>
                                        <td>Tối đa {{ $room->capacity }} người</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Giường:</td>
                                        <td>{{ $room->bed_type ?? 'Tiêu chuẩn' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Vị trí:</td>
                                        <td>{{ $room->location ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Loại phòng:</td>
                                        <td>{{ $room->category->name ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @if($room->description)
                                <p style="margin-top: 15px;">{{ $room->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="rd-reviews" id="reviews">
                        <h4>Đánh giá từ khách hàng
                            @if($room->reviews->count() > 0)
                                <small>({{ $room->reviews->count() }} đánh giá)</small>
                            @endif
                        </h4>

                        @forelse($room->reviews as $review)
                            <div class="review-item">
                                <div class="ri-pic">
                                    <img src="{{ asset('img/room/avatar/avatar-1.jpg') }}"
                                         alt="{{ $review->user->name ?? 'Khách' }}">
                                </div>
                                <div class="ri-text">
                                    <span>{{ $review->created_at->format('d \T\h\á\n\g n, Y') }}</span>
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="icon_star"></i>
                                            @else
                                                <i class="icon_star" style="opacity:0.3"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <h5>{{ $review->user->name ?? 'Khách ẩn danh' }}</h5>
                                    <p>{{ $review->comment }}</p>
                                </div>
                            </div>
                        @empty
                            <p>Chưa có đánh giá nào cho phòng này.</p>
                        @endforelse
                    </div>

                    <!-- Review Form -->
                    @auth
                        <div class="review-add">
                            <h4>Để lại đánh giá</h4>
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                             <form action="{{ route('reviews.store') }}" method="POST" class="ra-form">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <h5>Đánh giá:</h5>
                                            <select name="rating" class="form-control mb-3" style="width: auto; display: inline-block;">
                                                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 Sao ★★★★★</option>
                                                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Sao ★★★★</option>
                                                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Sao ★★★</option>
                                                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Sao ★★</option>
                                                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Sao ★</option>
                                            </select>
                                            @error('rating')
                                                <span class="text-danger small" style="display: block; margin-top: -5px; margin-bottom: 15px;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <textarea name="comment" placeholder="Nội dung đánh giá của bạn" required>{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <span class="text-danger small" style="display: block; margin-top: -15px; margin-bottom: 15px;">{{ $message }}</span>
                                        @enderror
                                        <button type="submit">Gửi đánh giá</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="review-add">
                            <p><a href="{{ route('login') }}">Đăng nhập</a> để gửi đánh giá của bạn.</p>
                        </div>
                    @endauth
                </div>

                <!-- Booking Sidebar -->
                <div class="col-lg-4">
                    <div class="room-booking" id="booking-form">
                        <h3>Đặt phòng ngay</h3>
                        @if($errors->any())
                            <div class="alert alert-danger" style="border-radius: 4px; padding: 12px 16px; margin-bottom: 15px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
                                <ul class="mb-0" style="margin: 0; padding-left: 18px;">
                                    @foreach($errors->all() as $error)
                                        <li style="font-size: 13px;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('bookings.checkout', $room->id) }}" method="GET">
                            <div class="check-date">
                                <label for="date-in">Ngày nhận phòng:</label>
                                <input type="text" class="date-input" id="date-in" name="check_in"
                                       value="{{ request('check_in') }}">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Ngày trả phòng:</label>
                                <input type="text" class="date-input" id="date-out" name="check_out"
                                       value="{{ request('check_out') }}">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="select-option">
                                <label for="guest">Người lớn:</label>
                                <select id="guest" name="adults">
                                    <option value="1">1 Người lớn</option>
                                    <option value="2">2 Người lớn</option>
                                    <option value="3">3 Người lớn</option>
                                    <option value="4">4 Người lớn</option>
                                </select>
                            </div>
                            <div class="select-option">
                                <label for="children">Trẻ em:</label>
                                <select id="children" name="children">
                                    <option value="0">0 Trẻ em</option>
                                    <option value="1">1 Trẻ em</option>
                                    <option value="2">2 Trẻ em</option>
                                </select>
                            </div>
                            <div style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-radius: 4px;">
                                <strong>Giá: {{ number_format($room->price, 0, ',', '.') }} đ/đêm</strong>
                            </div>
                            <button type="submit">Đặt phòng ngay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Room Details Section End -->

@endsection
