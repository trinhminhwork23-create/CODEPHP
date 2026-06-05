

<?php $__env->startSection('content'); ?>

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Danh sách phòng nghỉ</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <span>Phòng nghỉ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="room-item">
                        <img src="<?php echo e(asset('img/room/room-1.jpg')); ?>" alt="">
                        <div class="ri-text">
                            <h4>Phòng Premium King</h4>
                            <h3>159$<span>/Đêm</span></h3>
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
                            <a href="<?php echo e(route('rooms.show', 1)); ?>" class="primary-btn">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="room-item">
                        <img src="<?php echo e(asset('img/room/room-2.jpg')); ?>" alt="">
                        <div class="ri-text">
                            <h4>Phòng Deluxe</h4>
                            <h3>159$<span>/Đêm</span></h3>
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
                <div class="col-lg-4 col-md-6">
                    <div class="room-item">
                        <img src="<?php echo e(asset('img/room/room-3.jpg')); ?>" alt="">
                        <div class="ri-text">
                            <h4>Phòng Double</h4>
                            <h3>159$<span>/Đêm</span></h3>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Diện tích:</td>
                                        <td>30 m2</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Sức chứa:</td>
                                        <td>Tối đa 2 người</td>
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
                <div class="col-lg-4 col-md-6">
                    <div class="room-item">
                        <img src="<?php echo e(asset('img/room/room-4.jpg')); ?>" alt="">
                        <div class="ri-text">
                            <h4>Phòng Luxury</h4>
                            <h3>159$<span>/Đêm</span></h3>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Diện tích:</td>
                                        <td>30 m2</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Sức chứa:</td>
                                        <td>Tối đa 1 người</td>
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
                <div class="col-lg-4 col-md-6">
                    <div class="room-item">
                        <img src="<?php echo e(asset('img/room/room-5.jpg')); ?>" alt="">
                        <div class="ri-text">
                            <h4>Phòng hướng cảnh quan</h4>
                            <h3>159$<span>/Đêm</span></h3>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Diện tích:</td>
                                        <td>30 m2</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Sức chứa:</td>
                                        <td>Tối đa 1 người</td>
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
                            <a href="<?php echo e(route('rooms.show', 5)); ?>" class="primary-btn">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="room-item">
                        <img src="<?php echo e(asset('img/room/room-6.jpg')); ?>" alt="">
                        <div class="ri-text">
                            <h4>Phòng hướng sân vườn</h4>
                            <h3>159$<span>/Đêm</span></h3>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Diện tích:</td>
                                        <td>30 m2</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Sức chứa:</td>
                                        <td>Tối đa 2 người</td>
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
                            <a href="<?php echo e(route('rooms.show', 6)); ?>" class="primary-btn">Xem chi tiết</a>
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
    <!-- Rooms Section End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/rooms/index.blade.php ENDPATH**/ ?>