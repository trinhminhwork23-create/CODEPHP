

<?php $__env->startSection('content'); ?>

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Phòng nghỉ của chúng tôi</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <a href="<?php echo e(route('rooms.index')); ?>">Phòng nghỉ</a>
                            <span>Phòng Premium King</span>
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
                        <img src="<?php echo e(asset('img/room/room-details.jpg')); ?>" alt="">
                        <div class="rd-text">
                            <div class="rd-title">
                                <h3>Phòng Premium King</h3>
                                <div class="rdt-right">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star-half_alt"></i>
                                    </div>
                                    <a href="#">Đặt phòng ngay</a>
                                </div>
                            </div>
                            <h2>159$<span>/Đêm</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Diện tích:</td>
                                        <td>30 m2</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Sức chứa:</td>
                                        <td>Tối đa 3 người</td>
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
                            </p>
                        </div>
                    </div>
                    <div class="rd-reviews" id="reviews">
                        <h4>Đánh giá từ khách hàng</h4>
                        <div class="review-item">
                            <div class="ri-pic">
                                <img src="<?php echo e(asset('img/room/avatar/avatar-1.jpg')); ?>" alt="">
                            </div>
                            <div class="ri-text">
                                <span>27 Tháng 8, 2019</span>
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5>Minh Anh</h5>
                                <p>Phòng nghỉ vô cùng sạch sẽ và thoáng đãng, view ngắm hoàng hôn thung lũng đẹp xuất sắc. Các dịch vụ tiện ích như bồn tắm ngâm thảo dược rất thư giãn. Gia đình tôi sẽ quay lại Sapa Jade Hill vào kỳ nghỉ tới!</p>
                            </div>
                        </div>
                        <div class="review-item">
                            <div class="ri-pic">
                                <img src="<?php echo e(asset('img/room/avatar/avatar-2.jpg')); ?>" alt="">
                            </div>
                            <div class="ri-text">
                                <span>15 Tháng 9, 2019</span>
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5>Hoàng Lâm</h5>
                                <p>Không gian yên bình và trong lành, thích hợp để trốn khỏi sự xô bồ của thành phố. Dịch vụ đưa đón tận nơi rất tiện lợi và nhân viên thân thiện, chu đáo. Rất đáng trải nghiệm!</p>
                            </div>
                        </div>
                    </div>
                    <div class="review-add">
                        <h4>Để lại đánh giá</h4>
                        <form action="<?php echo e(route('reviews.store')); ?>" method="POST" class="ra-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="room_id" value="<?php echo e($room->id ?? 1); ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" name="name" placeholder="Họ và tên">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="email" placeholder="Địa chỉ Email">
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <h5>Đánh giá:</h5>
                                        <div class="rating">
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star"></i>
                                            <i class="icon_star-half_alt"></i>
                                        </div>
                                        <select name="rating" class="form-control mb-3" style="width: auto; display: inline-block;">
                                            <option value="5">5 Sao</option>
                                            <option value="4">4 Sao</option>
                                            <option value="3">3 Sao</option>
                                            <option value="2">2 Sao</option>
                                            <option value="1">1 Sao</option>
                                        </select>
                                    </div>
                                    <textarea name="comment" placeholder="Nội dung đánh giá của bạn"></textarea>
                                    <button type="submit">Gửi đánh giá</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="room-booking">
                        <h3>Đặt phòng ngay</h3>
                        <form action="<?php echo e(route('bookings.checkout', $room->id ?? 1)); ?>" method="GET">
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
    </section>
    <!-- Room Details Section End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/rooms/show.blade.php ENDPATH**/ ?>