@extends('layouts.master')

@section('content')

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Tin tức & Sự kiện</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <span>Tin tức</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section blog-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-1.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Hành trình du lịch</span>
                                <h4><a href="{{ route('blog.show', 1) }}">Hành trình trekking khám phá bản Lao Chải - Tả Van mùa lúa chín vàng óng ả</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 15 Tháng Tư, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-2.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Nghỉ dưỡng sinh thái</span>
                                <h4><a href="{{ route('blog.show', 2) }}">Trải nghiệm nghỉ dưỡng sinh thái Eco-Luxury nguyên bản bên rặng Hoàng Liên Sơn</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 15 Tháng Tư, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-3.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Kiến trúc đá</span>
                                <h4><a href="{{ route('blog.show', 3) }}">Nghệ thuật kiến trúc độc bản của biệt thự đá mộc mạc ẩn mình trong sương mờ</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 21 Tháng Tư, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-4.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Trải nghiệm săn mây</span>
                                <h4><a href="{{ route('blog.show', 4) }}">Chuyến săn mây bồng bềnh bên thung lũng Mường Hoa từ ban công biệt thự</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 22 Tháng Tư, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-5.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Spa & Trị liệu</span>
                                <h4><a href="{{ route('blog.show', 5) }}">Kinh nghiệm ngâm chân lá thuốc Dao đỏ truyền thống và trị liệu spa thảo mộc rừng</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 25 Tháng Tư, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-6.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Hành trình du lịch</span>
                                <h4><a href="{{ route('blog.show', 6) }}">Những cung đường đồi thông cổ thụ mờ sương đẹp nhất bao quanh khu nghỉ dưỡng</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 29 Tháng Tư, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-7.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Trà chiều ngắm mây</span>
                                <h4><a href="{{ route('blog.show', 7) }}">Trải nghiệm trà chiều sang trọng ngắm mây ngàn tại Nest Club trên đỉnh đồi</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 05 Tháng Năm, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-8.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Khám phá văn hóa</span>
                                <h4><a href="{{ route('blog.show', 8) }}">Khám phá văn hóa bản địa của người H'Mông và Dao đỏ tại thung lũng Mường Hoa</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 08 Tháng Năm, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item set-bg" data-setbg="{{ asset('img/blog/blog-9.jpg') }}">
                            <div class="bi-text">
                                <span class="b-tag">Ẩm thực Tây Bắc</span>
                                <h4><a href="{{ route('blog.show', 9) }}">Hành trình ẩm thực Tây Bắc tinh tế chuẩn vị núi rừng kết hợp fine-dining</a></h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> 12 Tháng Năm, 2026</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="room-pagination">
                            <a href="#">1</a>
                            <a href="#">2</a>
                            <a href="#">Trang sau <i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

@endsection
