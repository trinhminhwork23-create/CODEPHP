

<?php $__env->startSection('content'); ?>

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Sona - Nghỉ dưỡng sang trọng</h1>
                        <p>Chào mừng bạn đến với thiên đường nghỉ dưỡng đẳng cấp, nơi mang lại trải nghiệm tinh tế và dịch vụ hoàn hảo hàng đầu.</p>
                        <a href="<?php echo e(route('about')); ?>" class="primary-btn">Khám phá ngay</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Đặt phòng nghỉ dưỡng</h3>
                        <form action="<?php echo e(route('rooms.search')); ?>" method="GET">
                            <div class="check-date">
                                <label for="date-in">Ngày nhận phòng:</label>
                                <input type="text" class="date-input" id="date-in" name="check_in">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Ngày trả phòng:</label>
                                <input type="text" class="date-input" id="date-out" name="check_out">
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
                                <label for="room">Trẻ em:</label>
                                <select id="room" name="children">
                                    <option value="0">0 Trẻ em</option>
                                    <option value="1">1 Trẻ em</option>
                                    <option value="2">2 Trẻ em</option>
                                </select>
                            </div>
                            <button type="submit">Kiểm tra phòng trống</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="<?php echo e(asset('img/hero/hero-1.jpg')); ?>"></div>
            <div class="hs-item set-bg" data-setbg="<?php echo e(asset('img/hero/hero-2.jpg')); ?>"></div>
            <div class="hs-item set-bg" data-setbg="<?php echo e(asset('img/hero/hero-3.jpg')); ?>"></div>
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
                        <a href="<?php echo e(route('about')); ?>" class="primary-btn about-btn">Xem thêm</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="<?php echo e(asset('img/about/about-1.jpg')); ?>" alt="">
                            </div>
                            <div class="col-sm-6">
                                <img src="<?php echo e(asset('img/about/about-2.jpg')); ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Services Section End -->
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
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="<?php echo e(asset('img/room/room-b1.jpg')); ?>">
                            <div class="hr-text">
                                <h3>Phòng đôi Sang trọng</h3>
                                <h2>199$<span>/Đêm</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Diện tích:</td>
                                            <td>30 m2</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Sức chứa:</td>
                                            <td>Tối đa 5 người</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Giường:</td>
                                            <td>Giường King cỡ lớn</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Dịch vụ:</td>
                                            <td>Wifi, Tivi, Phòng tắm cao cấp,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="<?php echo e(route('rooms.show', 1)); ?>" class="primary-btn">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="<?php echo e(asset('img/room/room-b2.jpg')); ?>">
                            <div class="hr-text">
                                <h3>Phòng Premium King</h3>
                                <h2>159$<span>/Đêm</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Diện tích:</td>
                                            <td>30 m2</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Sức chứa:</td>
                                            <td>Tối đa 5 người</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Giường:</td>
                                            <td>Giường King cỡ lớn</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Dịch vụ:</td>
                                            <td>Wifi, Tivi, Phòng tắm cao cấp,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="<?php echo e(route('rooms.show', 2)); ?>" class="primary-btn">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="<?php echo e(asset('img/room/room-b3.jpg')); ?>">
                            <div class="hr-text">
                                <h3>Phòng Deluxe</h3>
                                <h2>198$<span>/Đêm</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Diện tích:</td>
                                            <td>30 m2</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Sức chứa:</td>
                                            <td>Tối đa 5 người</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Giường:</td>
                                            <td>Giường King cỡ lớn</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Dịch vụ:</td>
                                            <td>Wifi, Tivi, Phòng tắm cao cấp,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="<?php echo e(route('rooms.show', 3)); ?>" class="primary-btn">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="<?php echo e(asset('img/room/room-b4.jpg')); ?>">
                            <div class="hr-text">
                                <h3>Phòng Gia đình</h3>
                                <h2>299$<span>/Đêm</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Diện tích:</td>
                                            <td>30 m2</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Sức chứa:</td>
                                            <td>Tối đa 5 người</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Giường:</td>
                                            <td>Giường King cỡ lớn</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Dịch vụ:</td>
                                            <td>Wifi, Tivi, Phòng tắm cao cấp,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="<?php echo e(route('rooms.show', 4)); ?>" class="primary-btn">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
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
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="<?php echo e(asset('img/testimonial-logo.png')); ?>" alt="">
                        </div>
                        <div class="ts-item">
                            <p>Dịch vụ tuyệt vời và phòng ốc sang trọng. Chúng tôi đã có một kỳ nghỉ cuối tuần vô cùng thư giãn, nhân viên ở đây thực sự chu đáo và chuyên nghiệp. Chắc chắn tôi sẽ giới thiệu Sona cho bạn bè và người thân.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="<?php echo e(asset('img/testimonial-logo.png')); ?>" alt="">
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
                    <div class="blog-item set-bg" data-setbg="<?php echo e(asset('img/blog/blog-1.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Hành trình du lịch</span>
                            <h4><a href="<?php echo e(route('blog.show', 1)); ?>">Hành trình khám phá Tremblant, Canada</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="<?php echo e(asset('img/blog/blog-2.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Cắm trại dã ngoại</span>
                            <h4><a href="<?php echo e(route('blog.show', 2)); ?>">Kinh nghiệm lựa chọn xe cắm trại tiện nghi</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="<?php echo e(asset('img/blog/blog-3.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Sự kiện</span>
                            <h4><a href="<?php echo e(route('blog.show', 3)); ?>">Khám phá vẻ đẹp kỳ vĩ của Copper Canyon</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 21 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog-item small-size set-bg" data-setbg="<?php echo e(asset('img/blog/blog-wide.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Sự kiện</span>
                            <h4><a href="<?php echo e(route('blog.show', 4)); ?>">Chuyến đi đến Iqaluit, thành phố Bắc Cực hoang sơ của Canada</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 08 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item small-size set-bg" data-setbg="<?php echo e(asset('img/blog/blog-10.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Du lịch</span>
                            <h4><a href="<?php echo e(route('blog.show', 5)); ?>">Kinh nghiệm du lịch tự túc tại Barcelona</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 12 Tháng Tư, 2019</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/home.blade.php ENDPATH**/ ?>