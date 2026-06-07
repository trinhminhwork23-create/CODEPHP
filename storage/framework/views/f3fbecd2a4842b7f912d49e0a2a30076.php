<?php $__env->startSection('content'); ?>

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Sapa Jade Hill Resort & Spa</h1>
                        <p>Bản giao hưởng giữa mây trời Sa Pa. Khởi đầu hành trình sinh thái xa hoa bên lề thung lũng Mường Hoa kỳ vĩ, bao quanh bởi rừng thông cổ thụ mờ sương và những biệt thự đá mộc mạc mang đậm hơi thở Tây Bắc.</p>
                        <a href="<?php echo e(route('about')); ?>" class="primary-btn">Khám phá ngay</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Đặt phòng nghỉ dưỡng</h3>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger sapa-alert-danger">
                                <ul class="mb-0" style="margin: 0; padding-left: 18px;">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li style="font-size: 13px;"><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('rooms.search')); ?>" method="GET">
                            <div class="check-date">
                                <label for="date-in">Ngày nhận phòng:</label>
                                <input type="text" class="date-input" id="date-in" name="check_in" value="<?php
                                    $checkInValue = old('check_in') ?: request('check_in');
                                    if ($checkInValue) {
                                        try {
                                            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $checkInValue)) {
                                                echo \Carbon\Carbon::createFromFormat('d/m/Y', $checkInValue)->format('Y-m-d');
                                            } else {
                                                echo \Carbon\Carbon::parse($checkInValue)->format('Y-m-d');
                                            }
                                        } catch (\Exception $e) {
                                            echo $checkInValue;
                                        }
                                    }
                                ?>">
                                <i class="icon_calendar"></i>
                                <?php $__errorArgs = ['check_in'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small sapa-error-msg"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Ngày trả phòng:</label>
                                <input type="text" class="date-input" id="date-out" name="check_out" value="<?php
                                    $checkOutValue = old('check_out') ?: request('check_out');
                                    if ($checkOutValue) {
                                        try {
                                            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $checkOutValue)) {
                                                echo \Carbon\Carbon::createFromFormat('d/m/Y', $checkOutValue)->format('Y-m-d');
                                            } else {
                                                echo \Carbon\Carbon::parse($checkOutValue)->format('Y-m-d');
                                            }
                                        } catch (\Exception $e) {
                                            echo $checkOutValue;
                                        }
                                    }
                                ?>">
                                <i class="icon_calendar"></i>
                                <?php $__errorArgs = ['check_out'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small sapa-error-msg"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="select-option">
                                <label for="guest">Người lớn:</label>
                                <select id="guest" name="adults">
                                    <?php for($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e((request('adults') ?? old('adults', 1)) == $i ? 'selected' : ''); ?>>
                                            <?php echo e($i); ?> Người lớn
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <?php $__errorArgs = ['adults'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small sapa-error-msg"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="select-option">
                                <label for="room">Trẻ em:</label>
                                <select id="room" name="children">
                                    <?php for($i = 0; $i <= 10; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e((request('children') ?? old('children', 0)) == $i ? 'selected' : ''); ?>>
                                            <?php echo e($i); ?> Trẻ em
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <?php $__errorArgs = ['children'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small sapa-error-msg"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                            <h2>Khu Nghỉ dưỡng Sinh thái Núi Cao cấp<br />Sapa Jade Hill Resort & Spa</h2>
                        </div>
                        <p class="f-para">Sapa Jade Hill Resort & Spa ẩn mình giữa đồi thông mờ sương cổ thụ, nhìn thẳng ra thung lũng Mường Hoa - di sản thiên nhiên hùng vĩ. Mỗi căn biệt thự đá độc bản tại đây là sự kết hợp tinh tế giữa văn hóa bản địa mộc mạc Tây Bắc và dịch vụ chăm sóc eco-luxury đẳng cấp quốc tế.</p>
                        <p class="s-para">Chúng tôi đem đến các không gian biệt thự riêng tư với lò sưởi củi đá truyền thống và bồn tắm gỗ Pơ-mu tự nhiên, giúp quý khách hoàn toàn giao hòa với thiên nhiên và phục hồi tâm trí nguyên bản.</p>
                        <a href="<?php echo e(route('about')); ?>" class="primary-btn about-btn">Xem thêm</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="<?php echo e(asset('img/about/about-1.jpg')); ?>" alt="Sapa Jade Hill Landscape 1">
                            </div>
                            <div class="col-sm-6">
                                <img src="<?php echo e(asset('img/about/about-2.jpg')); ?>" alt="Sapa Jade Hill Landscape 2">
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
                        <h2>Khám phá trải nghiệm sinh thái cao cấp</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-036-parking"></i>
                        <h4>Lịch trình du lịch</h4>
                        <p>Khám phá thung lũng Mường Hoa, chinh phục đỉnh Fansipan và trải nghiệm văn hóa bản địa Sa Pa độc đáo.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-033-dinner"></i>
                        <h4>Dịch vụ ẩm thực</h4>
                        <p>Thưởng thức ẩm thực Tây Bắc tinh tế, các món ăn đặc sản Sa Pa hòa quyện cùng phong vị quốc tế thượng hạng tại nhà hàng ấm cúng.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-026-bed"></i>
                        <h4>Spa & Trị liệu</h4>
                        <p>Trị liệu tắm lá thuốc người Dao đỏ truyền thống, xông hơi đá nóng núi lửa giúp phục hồi năng lượng tối đa sau chuyến hành trình.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-024-towel"></i>
                        <h4>Dịch vụ giặt là</h4>
                        <p>Giặt là cao cấp chuyên nghiệp sử dụng công nghệ sinh thái, giữ gìn trang phục thơm tho hương thảo mộc núi rừng Tây Bắc.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-044-clock-1"></i>
                        <h4>Thuê tài xế riêng</h4>
                        <p>Đưa đón VIP từ sân bay, ga tàu bằng xe đời mới cùng tài xế riêng am hiểu từng cung đường đèo hiểm trở của Sa Pa.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-012-cocktail"></i>
                        <h4>Quầy bar & Đồ uống</h4>
                        <p>Không gian trà chiều ngắm mây ngàn bềnh bồng bên thung lũng và thưởng thức cocktail pha chế từ thảo mộc địa phương.</p>
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
                    <?php $__empty_1 = true; $__currentLoopData = $featuredRooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $badge = "Eco-Luxury Suite";
                            if ($room->id == 1) $badge = "Luxury Eco-Villa";
                            elseif ($room->id == 2) $badge = "Được đặt nhiều nhất tuần này";
                            elseif ($room->id == 3) $badge = "Bán chạy nhất";
                            elseif ($room->id == 4) $badge = "View thung lũng cực đẹp";
                            
                            $amenities = ["View Thung lũng Mường Hoa", "Lò sưởi củi đá", "Bồn tắm gỗ Pơ-mu"];
                            if ($room->id % 2 == 0) {
                                $amenities = ["View Đồi Thông Mờ Sương", "Ban công panorama", "Bể bơi nước nóng"];
                            }
                        ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="hp-room-item set-bg" data-setbg="<?php echo e(asset('img/rooms/room_' . $room->id . '.jpg')); ?>">
                                <div class="hr-text">
                                    <div class="sapa-badge-container">
                                        <span class="sapa-urgency-badge"><?php echo e($badge); ?></span>
                                    </div>
                                    <h3><?php echo e($room->name); ?></h3>
                                    <div class="sapa-stars">
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </div>
                                    <h2><?php echo e(number_format($room->price, 0, ',', '.')); ?><span> đ/Đêm</span></h2>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="r-o">Diện tích:</td>
                                                <td><?php echo e($room->size ? $room->size . ' m²' : 'N/A'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Sức chứa:</td>
                                                <td>Tối đa <?php echo e($room->capacity); ?> người</td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Giường:</td>
                                                <td><?php echo e($room->bed_type ?? 'Tiêu chuẩn'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Loại phòng:</td>
                                                <td><?php echo e($room->category->name ?? 'N/A'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Đặc trưng:</td>
                                                <td>
                                                    <div class="sapa-card-amenity-list">
                                                        <?php $__currentLoopData = $amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span class="sapa-card-amenity-item"><i class="fa fa-check"></i> <?php echo e($amenity); ?></span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="<?php echo e(route('rooms.show', $room->id)); ?>" class="primary-btn">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-lg-12 text-center">
                            <p>Hiện chưa có phòng nào được cập nhật.</p>
                        </div>
                    <?php endif; ?>
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
                        <h2>Ý kiến khách hàng về Sapa Jade Hill</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="testimonial-slider owl-carousel">
                        <div class="ts-item">
                            <p>Gia đình tôi đã có một kỳ nghỉ cuối tuần tuyệt vời tại Sapa Jade Hill. Trải nghiệm thức dậy giữa đồi thông mờ sương và bồn tắm gỗ Pơ-mu thơm phức làm chúng tôi vô cùng sảng khoái. Nhân viên chu đáo, cảnh sắc thung lũng Mường Hoa quá đỗi kỳ vĩ.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i>
                                    <i class="icon_star"></i><i class="icon_star"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="<?php echo e(asset('img/testimonial-logo.png')); ?>" alt="Testimonial Logo">
                        </div>
                        <div class="ts-item">
                            <p>Không gian biệt thự đá sinh thái eco-luxury quá tuyệt vời. Lò sưởi củi đá sưởi ấm căn phòng trong những đêm sương mù lạnh giá của Sa Pa. Ẩm thực nhà hàng cũng vô cùng đặc sắc và đậm chất Tây Bắc.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i>
                                    <i class="icon_star"></i><i class="icon_star"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="<?php echo e(asset('img/testimonial-logo.png')); ?>" alt="Testimonial Logo">
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
                        <span>Cẩm nang Sapa Jade Hill</span>
                        <h2>Tin tức & Sự kiện nổi bật</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="<?php echo e(asset('img/blog/blog-1.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Hành trình du lịch</span>
                            <h4><a href="<?php echo e(route('blog.show', 1)); ?>">Hành trình trekking khám phá bản Lao Chải - Tả Van mùa lúa chín</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15 Tháng Tư, 2026</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="<?php echo e(asset('img/blog/blog-2.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Cắm trại dã ngoại</span>
                            <h4><a href="<?php echo e(route('blog.show', 2)); ?>">Trải nghiệm nghỉ dưỡng sinh thái Eco-Luxury bên rặng Hoàng Liên Sơn</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15 Tháng Tư, 2026</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="<?php echo e(asset('img/blog/blog-3.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Sự kiện</span>
                            <h4><a href="<?php echo e(route('blog.show', 3)); ?>">Nghệ thuật kiến trúc biệt thự đá độc bản tại Sapa Jade Hill</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 21 Tháng Tư, 2026</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog-item small-size set-bg" data-setbg="<?php echo e(asset('img/blog/blog-wide.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Sự kiện</span>
                            <h4><a href="<?php echo e(route('blog.show', 4)); ?>">Chuyến săn mây bồng bềnh bên thung lũng Mường Hoa từ ban công biệt thự</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 08 Tháng Tư, 2026</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item small-size set-bg" data-setbg="<?php echo e(asset('img/blog/blog-10.jpg')); ?>">
                        <div class="bi-text">
                            <span class="b-tag">Du lịch</span>
                            <h4><a href="<?php echo e(route('blog.show', 5)); ?>">Kinh nghiệm ngâm chân lá thuốc Dao đỏ và xông hơi đá muối đỉnh cao</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 12 Tháng Tư, 2026</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .sapa-alert-danger { border-radius: 4px; padding: 12px 16px; margin-bottom: 15px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
    .sapa-error-msg { display: block; margin-top: 5px; }
    .sapa-stars { color: #dfa974; margin-bottom: 8px; font-size: 13px; }
    .sapa-badge-container { margin-bottom: 12px; }
    .sapa-urgency-badge { background: #dfa974; color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; box-shadow: 0 4px 10px rgba(223, 169, 116, 0.3); }
    .sapa-card-amenity-list { display: flex; flex-direction: column; gap: 4px; }
    .sapa-card-amenity-item { font-size: 12px; color: #c89560; font-weight: 500; }
    .sapa-card-amenity-item i { margin-right: 4px; font-size: 10px; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/home.blade.php ENDPATH**/ ?>