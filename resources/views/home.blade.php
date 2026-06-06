@extends('layouts.master')

@section('content')

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Sona - Nghỉ dưỡng sang trọng</h1>
                        <p>Chào mừng bạn đến với thiên đường nghỉ dưỡng đẳng cấp, nơi mang lại trải nghiệm tinh tế và dịch vụ hoàn hảo hàng đầu.</p>
                        <a href="{{ route('about') }}" class="primary-btn">Khám phá ngay</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Đặt phòng nghỉ dưỡng</h3>
                        @if($errors->any())
                            <div class="alert alert-danger" style="border-radius: 4px; padding: 12px 16px; margin-bottom: 15px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
                                <ul class="mb-0" style="margin: 0; padding-left: 18px;">
                                    @foreach($errors->all() as $error)
                                        <li style="font-size: 13px;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('rooms.search') }}" method="GET">
                            <div class="check-date">
                                <label for="date-in">Ngày nhận phòng:</label>
                                <input type="text" class="date-input" id="date-in" name="check_in" value="{{ request('check_in') ?? old('check_in') }}">
                                <i class="icon_calendar"></i>
                                @error('check_in')
                                    <span class="text-danger small" style="display: block; margin-top: 5px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="check-date">
                                <label for="date-out">Ngày trả phòng:</label>
                                <input type="text" class="date-input" id="date-out" name="check_out" value="{{ request('check_out') ?? old('check_out') }}">
                                <i class="icon_calendar"></i>
                                @error('check_out')
                                    <span class="text-danger small" style="display: block; margin-top: 5px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="select-option">
                                <label for="guest">Người lớn:</label>
                                <select id="guest" name="adults">
                                    <option value="1" {{ (request('adults') ?? old('adults')) == 1 ? 'selected' : '' }}>1 Người lớn</option>
                                    <option value="2" {{ (request('adults') ?? old('adults')) == 2 ? 'selected' : '' }}>2 Người lớn</option>
                                    <option value="3" {{ (request('adults') ?? old('adults')) == 3 ? 'selected' : '' }}>3 Người lớn</option>
                                    <option value="4" {{ (request('adults') ?? old('adults')) == 4 ? 'selected' : '' }}>4 Người lớn</option>
                                </select>
                                @error('adults')
                                    <span class="text-danger small" style="display: block; margin-top: 5px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="select-option">
                                <label for="room">Trẻ em:</label>
                                <select id="room" name="children">
                                    <option value="0" {{ (request('children') ?? old('children')) == 0 ? 'selected' : '' }}>0 Trẻ em</option>
                                    <option value="1" {{ (request('children') ?? old('children')) == 1 ? 'selected' : '' }}>1 Trẻ em</option>
                                    <option value="2" {{ (request('children') ?? old('children')) == 2 ? 'selected' : '' }}>2 Trẻ em</option>
                                </select>
                                @error('children')
                                    <span class="text-danger small" style="display: block; margin-top: 5px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit">Kiểm tra phòng trống</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}"></div>
            <div class="hs-item set-bg" data-setbg="{{ asset('img/hero/hero-2.jpg') }}"></div>
            <div class="hs-item set-bg" data-setbg="{{ asset('img/hero/hero-3.jpg') }}"></div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Us Section Begin -->
    <section class="aboutus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>Về chúng tôi</span>
                            <h2>Không gian Nghỉ dưỡng <br />Đẳng cấp Quốc tế</h2>
                        </div>
                        <p class="f-para">Sona tự hào là điểm đến nghỉ dưỡng hàng đầu, nơi kết hợp giữa thiên nhiên thơ mộng và sự tiện nghi sang trọng bậc nhất. Chúng tôi luôn mong muốn mang lại sự hài lòng tối đa cho từng khoảnh khắc nghỉ ngơi của bạn.</p>
                        <p class="s-para">Cho dù bạn đang tìm kiếm một căn phòng sang trọng, biệt thự riêng tư hay trải nghiệm nghỉ dưỡng khác biệt, chúng tôi luôn sẵn sàng đáp ứng mọi nhu cầu.</p>
                        <a href="{{ route('about') }}" class="primary-btn about-btn">Xem thêm</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{ asset('img/about/about-1.jpg') }}" alt="">
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ asset('img/about/about-2.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Services Section Begin -->
    <section class="services-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Dịch vụ của chúng tôi</span>
                        <h2>Khám phá trải nghiệm đẳng cấp</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-036-parking"></i>
                        <h4>Lịch trình du lịch</h4>
                        <p>Chúng tôi cung cấp các gói tham quan và khám phá độc đáo, mang đến những trải nghiệm du lịch trọn vẹn nhất.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-033-dinner"></i>
                        <h4>Dịch vụ ẩm thực</h4>
                        <p>Thưởng thức những tinh hoa ẩm thực từ các đầu bếp đẳng cấp quốc tế ngay tại không gian sang trọng.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-026-bed"></i>
                        <h4>Trông trẻ</h4>
                        <p>Dịch vụ chăm sóc trẻ em tận tâm, an toàn giúp các bậc phụ huynh tận hưởng trọn vẹn kỳ nghỉ.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-024-towel"></i>
                        <h4>Giặt là cao cấp</h4>
                        <p>Dịch vụ giặt là chuyên nghiệp với tiêu chuẩn khắt khe, giữ cho trang phục của bạn luôn hoàn hảo.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-044-clock-1"></i>
                        <h4>Thuê tài xế riêng</h4>
                        <p>Dịch vụ đưa đón tận nơi với tài xế riêng thân thiện, đảm bảo sự thoải mái và riêng tư tuyệt đối.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-012-cocktail"></i>
                        <h4>Quầy bar & Đồ uống</h4>
                        <p>Đắm chìm trong những ly cocktail hảo hạng được pha chế chuyên biệt tại không gian bar thư thái.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Home Room Section Begin -->
    <section class="hp-room-section">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                    @forelse($featuredRooms as $room)
                        @php
                            $fallbackImages = [
                                'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80',
                                'https://images.unsplash.com/photo-1590490360182-c33d955c4644?w=800&q=80',
                                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80',
                                'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80',
                            ];
                            $imgSrc = ($room->image && file_exists(public_path('storage/' . $room->image)))
                                ? asset('storage/' . $room->image)
                                : $fallbackImages[$loop->index % count($fallbackImages)];
                        @endphp
                        <div class="col-lg-3 col-md-6">
                            <div class="hp-room-item set-bg" data-setbg="{{ $imgSrc }}">
                                <div class="hr-text">
                                    <h3>{{ $room->name }}</h3>
                                    <h2>{{ number_format($room->price, 0, ',', '.') }}<span> đ/Đêm</span></h2>
                                    <table>
                                        <tbody>
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
                                                <td class="r-o">Loại phòng:</td>
                                                <td>{{ $room->category->name ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ route('rooms.show', $room->id) }}" class="primary-btn">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12 text-center">
                            <p>Hiện chưa có phòng nào được cập nhật.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- Home Room Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Đánh giá từ khách hàng</span>
                        <h2>Khách hàng nói gì về Sona?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="testimonial-slider owl-carousel">
                        <div class="ts-item">
                            <p>Sau khi công trình xây dựng nhà kéo dài hơn dự kiến, gia đình tôi cần một nơi để lưu trú vài ngày. Là một người bản địa, tôi biết rất nhiều về các lựa chọn chỗ ở trong thành phố, và chúng tôi hoàn toàn hài lòng với kỳ nghỉ tuyệt vời tại khách sạn Sona.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i>
                                    <i class="icon_star"></i><i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="{{ asset('img/testimonial-logo.png') }}" alt="">
                        </div>
                        <div class="ts-item">
                            <p>Dịch vụ tuyệt vời và phòng ốc sang trọng. Chúng tôi đã có một kỳ nghỉ cuối tuần vô cùng thư giãn, nhân viên ở đây thực sự chu đáo và chuyên nghiệp. Chắc chắn tôi sẽ giới thiệu Sona cho bạn bè và người thân.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i>
                                    <i class="icon_star"></i><i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="{{ asset('img/testimonial-logo.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Tin tức khách sạn</span>
                        <h2>Tin tức & Sự kiện nổi bật</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-1.jpg') }}">
                        <div class="bi-text">
                            <span class="b-tag">Hành trình du lịch</span>
                            <h4><a href="{{ route('blog.show', 1) }}">Hành trình khám phá Tremblant, Canada</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-2.jpg') }}">
                        <div class="bi-text">
                            <span class="b-tag">Cắm trại dã ngoại</span>
                            <h4><a href="{{ route('blog.show', 2) }}">Kinh nghiệm lựa chọn xe cắm trại tiện nghi</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-3.jpg') }}">
                        <div class="bi-text">
                            <span class="b-tag">Sự kiện</span>
                            <h4><a href="{{ route('blog.show', 3) }}">Khám phá vẻ đẹp kỳ vĩ của Copper Canyon</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 21 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog-item small-size set-bg" data-setbg="{{ asset('img/blog/blog-wide.jpg') }}">
                        <div class="bi-text">
                            <span class="b-tag">Sự kiện</span>
                            <h4><a href="{{ route('blog.show', 4) }}">Chuyến đi đến Iqaluit, thành phố Bắc Cực hoang sơ của Canada</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 08 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item small-size set-bg" data-setbg="{{ asset('img/blog/blog-10.jpg') }}">
                        <div class="bi-text">
                            <span class="b-tag">Du lịch</span>
                            <h4><a href="{{ route('blog.show', 5) }}">Kinh nghiệm du lịch tự túc tại Barcelona</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 12 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

@endsection
