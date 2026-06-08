

<?php use \Illuminate\Support\Facades\Storage; ?>

<?php $__env->startSection('content'); ?>

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Danh sách biệt thự & phòng nghỉ</h2>
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

    
    <?php if(request('adults') || request('children') || request('check_in') || request('check_out') || request('search')): ?>
        <section class="py-3 sapa-filter-section">
            <div class="container">
                <div class="sapa-filter-container">
                    <span class="sapa-filter-title">
                        <i class="fa fa-filter sapa-filter-title-icon"></i> Bộ lọc đang áp dụng:
                    </span>
                    <?php if(request('search')): ?>
                        <span class="badge sapa-badge-orange">
                            <i class="fa fa-search sapa-badge-icon"></i> Từ khóa: "<?php echo e(request('search')); ?>"
                        </span>
                    <?php endif; ?>
                    <?php if(request('adults')): ?>
                        <span class="badge sapa-badge-orange">
                            <i class="fa fa-user sapa-badge-icon"></i> <?php echo e(request('adults')); ?> Người lớn
                        </span>
                    <?php endif; ?>
                    <?php if(request('children')): ?>
                        <span class="badge sapa-badge-orange">
                            <i class="fa fa-child sapa-badge-icon"></i> <?php echo e(request('children')); ?> Trẻ em
                        </span>
                    <?php endif; ?>
                    <?php if(request('check_in') && request('check_out')): ?>
                        <span class="badge sapa-badge-green">
                            <i class="fa fa-calendar sapa-badge-icon"></i> 
                            <?php echo e(\Carbon\Carbon::parse(request('check_in'))->format('d/m/Y')); ?> → <?php echo e(\Carbon\Carbon::parse(request('check_out'))->format('d/m/Y')); ?>

                        </span>
                    <?php endif; ?>
                    <a href="<?php echo e(route('rooms.index')); ?>" class="sapa-clear-filters">
                        <i class="fa fa-times-circle sapa-badge-icon"></i> Xóa bộ lọc
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad">
        <div class="container">
            <div class="row">
                <?php if($errors->any()): ?>
                    <div class="col-lg-12">
                        <div class="alert alert-danger sapa-alert-danger">
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
                            <div class="sapa-grid-badge-container">
                                <span class="sapa-grid-urgency-badge"><?php echo e($badge); ?></span>
                            </div>
                            <img src="<?php echo e($room->image ? asset($room->image) : asset('img/rooms/room_' . (($room->id - 1) % 17 + 1) . '.jpg')); ?>" alt="<?php echo e($room->name); ?>">
                            <div class="ri-text">
                                <div class="sapa-grid-stars">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                </div>
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
                                <a href="<?php echo e(route('rooms.show', [$room->id] + request()->query())); ?>" class="primary-btn">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-lg-12 text-center py-5 my-5">
                        <div class="mb-4">
                            <i class="icon_error-circle_alt sapa-empty-icon"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Không tìm thấy phòng phù hợp</h4>
                        <?php if(request('adults') || request('children')): ?>
                            <p class="text-secondary mt-2">
                                Hiện tại không có phòng nào phù hợp với yêu cầu:
                                <strong><?php echo e((int)request('adults') + (int)request('children')); ?> người</strong>
                                <br>Vui lòng thử lại với số lượng khách ít hơn hoặc chọn ngày khác.
                            </p>
                        <?php else: ?>
                            <p class="text-secondary mt-2">
                                Hiện tại không có phòng nào phù hợp với yêu cầu tìm kiếm của quý khách.<br>
                                Vui lòng thay đổi ngày nhận/trả phòng hoặc số lượng người để thử lại.
                            </p>
                        <?php endif; ?>
                        <a href="<?php echo e(route('home')); ?>" class="primary-btn mt-3 sapa-btn-retry">Tìm kiếm lại</a>
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

<?php $__env->startPush('styles'); ?>
<style>
    .sapa-filter-section { background-color: #f9f9f9; border-bottom: 1px solid #ebebeb; }
    .sapa-filter-container { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; }
    .sapa-filter-title { font-weight: 600; color: #19191a; font-size: 14px; }
    .sapa-filter-title-icon { margin-right: 6px; color: #dfa974; }
    .sapa-badge-orange { background-color: #dfa974; color: #ffffff; padding: 6px 12px; font-weight: 500; border-radius: 3px; font-size: 13px; }
    .sapa-badge-icon { margin-right: 4px; }
    .sapa-badge-green { background-color: #28a745; color: #ffffff; padding: 6px 12px; font-weight: 500; border-radius: 3px; font-size: 13px; }
    .sapa-clear-filters { margin-left: auto; color: #dc3545; font-weight: 600; font-size: 13px; text-decoration: none; transition: opacity 0.3s; }
    .sapa-clear-filters:hover { opacity: 0.7; }
    .sapa-alert-danger { border-radius: 4px; padding: 12px 16px; margin-bottom: 20px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
    .sapa-empty-icon { font-size: 60px; color: #dfa974; }
    .sapa-btn-retry { display: inline-block; padding: 12px 30px; }
    
    .sapa-grid-badge-container { position: absolute; z-index: 10; margin-top: 15px; margin-left: 15px; }
    .sapa-grid-urgency-badge { background: #dfa974; color: #fff; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(223, 169, 116, 0.3); }
    .sapa-grid-stars { color: #dfa974; margin-bottom: 8px; font-size: 12px; }
    .sapa-card-amenity-list { display: flex; flex-direction: column; gap: 4px; }
    .sapa-card-amenity-item { font-size: 12px; color: #c89560; font-weight: 500; }
    .sapa-card-amenity-item i { margin-right: 4px; font-size: 10px; }
    
    .room-item { position: relative; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/rooms/index.blade.php ENDPATH**/ ?>