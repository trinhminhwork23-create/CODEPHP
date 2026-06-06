<?php $__env->startSection('content'); ?>

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Giới thiệu</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <span>Giới thiệu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- About Us Page Section Begin -->
    <section class="aboutus-page-section spad">
        <div class="container">
            <div class="about-page-text">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ap-title">
                            <h2>Chào mừng đến với Sona.</h2>
                            <p>Được xây dựng vào năm 1910 trong thời kỳ Belle Époque hoàng kim, khu nghỉ dưỡng của chúng tôi mang kiến trúc cổ điển quý phái, tọa lạc tại vị trí đắc địa giúp quý khách dễ dàng di chuyển và tận hưởng kỳ nghỉ trọn vẹn.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-1">
                        <ul class="ap-services">
                            <li><i class="icon_check"></i> Ưu đãi 20% giá phòng nghỉ.</li>
                            <li><i class="icon_check"></i> Bữa sáng buffet hàng ngày miễn phí</li>
                            <li><i class="icon_check"></i> Dịch vụ giặt là miễn phí 3 món mỗi ngày</li>
                            <li><i class="icon_check"></i> Kết nối Wifi tốc độ cao miễn phí.</li>
                            <li><i class="icon_check"></i> Giảm giá 20% cho dịch vụ Ẩm thực & Đồ uống</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="about-page-services">
                <div class="row">
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="<?php echo e(asset('img/about/about-p1.jpg')); ?>">
                            <div class="api-text">
                                <h3>Dịch vụ nhà hàng ẩm thực</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="<?php echo e(asset('img/about/about-p2.jpg')); ?>">
                            <div class="api-text">
                                <h3>Du lịch & Dã ngoại</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="<?php echo e(asset('img/about/about-p3.jpg')); ?>">
                            <div class="api-text">
                                <h3>Tổ chức Sự kiện & Tiệc</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Page Section End -->

    <!-- Video Section Begin -->
    <section class="video-section set-bg" data-setbg="<?php echo e(asset('img/video-bg.jpg')); ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <h2>Khám phá không gian & dịch vụ của chúng tôi</h2>
                        <p>Trải nghiệm những khoảnh khắc tuyệt diệu tại Sona</p>
                        <a href="https://www.youtube.com/watch?v=EzKkl64rRbM" class="play-btn video-popup"><img
                                src="<?php echo e(asset('img/play.png')); ?>" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Video Section End -->

    <!-- Gallery Section Begin -->
    <section class="gallery-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Thư viện ảnh</span>
                        <h2>Không gian nghệ thuật & Phong cảnh</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="gallery-item set-bg" data-setbg="<?php echo e(asset('img/gallery/gallery-1.jpg')); ?>">
                        <div class="gi-text">
                            <h3>Phòng nghỉ sang trọng</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="<?php echo e(asset('img/gallery/gallery-3.jpg')); ?>">
                                <div class="gi-text">
                                    <h3>Phòng nghỉ sang trọng</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="<?php echo e(asset('img/gallery/gallery-4.jpg')); ?>">
                                <div class="gi-text">
                                    <h3>Phòng nghỉ sang trọng</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="gallery-item large-item set-bg" data-setbg="<?php echo e(asset('img/gallery/gallery-2.jpg')); ?>">
                        <div class="gi-text">
                            <h3>Phòng nghỉ sang trọng</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gallery Section End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/about.blade.php ENDPATH**/ ?>