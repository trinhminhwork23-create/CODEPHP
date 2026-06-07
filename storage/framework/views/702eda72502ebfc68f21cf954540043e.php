

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
                <?php if($errors->any()): ?>
                    <div class="col-lg-12">
                        <div class="alert alert-danger" style="border-radius: 4px; padding: 12px 16px; margin-bottom: 20px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
                            <ul class="mb-0" style="margin: 0; padding-left: 18px;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li style="font-size: 14px;"><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="room-item">
                            <?php
                                $roomFallbacks = [
                                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&q=80',
                                    'https://images.unsplash.com/photo-1590490360182-c33d955c4644?w=600&q=80',
                                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600&q=80',
                                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80',
                                ];
                                $roomImg = ($room->image && file_exists(public_path('storage/' . $room->image)))
                                    ? asset('storage/' . $room->image)
                                    : $roomFallbacks[$loop->index % count($roomFallbacks)];
                            ?>
                            <img src="<?php echo e($roomImg); ?>" alt="<?php echo e($room->name); ?>">
                            <div class="ri-text">
                                <h4><?php echo e($room->name); ?></h4>
                                <h3><?php echo e(number_format($room->price, 0, ',', '.')); ?><span> đ/Đêm</span></h3>
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
                                    </tbody>
                                </table>
                                <a href="<?php echo e(route('rooms.show', $room->id)); ?>" class="primary-btn">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-lg-12 text-center py-5 my-5">
                        <div class="mb-4">
                            <i class="icon_error-circle_alt" style="font-size: 60px; color: #dfa974;"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Không tìm thấy phòng phù hợp</h4>
                        <p class="text-secondary mt-2">Hiện tại không có phòng nào phù hợp với yêu cầu tìm kiếm của quý khách.<br>Vui lòng thay đổi ngày nhận/trả phòng hoặc số lượng người để thử lại.</p>
                        <a href="<?php echo e(route('home')); ?>" class="primary-btn mt-3" style="display: inline-block; padding: 12px 30px;">Tìm kiếm lại</a>
                    </div>
                <?php endif; ?>

                <?php if($rooms->hasPages()): ?>
                    <div class="col-lg-12">
                        <div class="room-pagination">
                            <?php echo e($rooms->links()); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Rooms Section End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\CODEPHP\resources\views/rooms/index.blade.php ENDPATH**/ ?>