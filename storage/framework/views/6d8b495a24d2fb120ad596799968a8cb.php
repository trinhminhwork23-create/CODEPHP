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
                            <span><?php echo e($room->name); ?></span>
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
                        <img src="<?php echo e($room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1200&q=80'); ?>"
                             alt="<?php echo e($room->name); ?>">
                        <div class="rd-text">
                            <div class="rd-title">
                                <h3><?php echo e($room->name); ?></h3>
                                <div class="rdt-right">
                                    
                                    <div class="rating">
                                        <?php $avg = round($avgRating ?? 0); ?>
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $avg): ?>
                                                <i class="icon_star"></i>
                                            <?php else: ?>
                                                <i class="icon_star" style="opacity:0.3"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <?php if($avgRating): ?>
                                            <small>(<?php echo e(number_format($avgRating, 1)); ?>/5 — <?php echo e($room->reviews->count()); ?> đánh giá)</small>
                                        <?php endif; ?>
                                    </div>
                                    <a href="#booking-form">Đặt phòng ngay</a>
                                </div>
                            </div>
                            <h2><?php echo e(number_format($room->price, 0, ',', '.')); ?><span> đ/Đêm</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Mã phòng:</td>
                                        <td><?php echo e($room->room_code); ?></td>
                                    </tr>
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
                                        <td class="r-o">Vị trí:</td>
                                        <td><?php echo e($room->location ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Loại phòng:</td>
                                        <td><?php echo e($room->category->name ?? 'N/A'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if($room->description): ?>
                                <p style="margin-top: 15px;"><?php echo e($room->description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="rd-reviews" id="reviews">
                        <h4>Đánh giá từ khách hàng
                            <?php if($room->reviews->count() > 0): ?>
                                <small>(<?php echo e($room->reviews->count()); ?> đánh giá)</small>
                            <?php endif; ?>
                        </h4>

                        <?php $__empty_1 = true; $__currentLoopData = $room->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="review-item">
                                <div class="ri-pic">
                                    <img src="<?php echo e(asset('img/room/avatar/avatar-1.jpg')); ?>"
                                         alt="<?php echo e($review->user->name ?? 'Khách'); ?>">
                                </div>
                                <div class="ri-text">
                                    <span><?php echo e($review->created_at->format('d \T\h\á\n\g n, Y')); ?></span>
                                    <div class="rating">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $review->rating): ?>
                                                <i class="icon_star"></i>
                                            <?php else: ?>
                                                <i class="icon_star" style="opacity:0.3"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <h5><?php echo e($review->user->name ?? 'Khách ẩn danh'); ?></h5>
                                    <p><?php echo e($review->comment); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>Chưa có đánh giá nào cho phòng này.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Review Form -->
                    <?php if(auth()->guard()->check()): ?>
                        <?php if($hasCompletedStay): ?>
                            <div class="review-add">
                                <h4>Để lại đánh giá</h4>
                                <?php if(session('success')): ?>
                                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                                <?php endif; ?>
                                <?php if(session('error')): ?>
                                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                                <?php endif; ?>
                                 <form action="<?php echo e(route('reviews.store')); ?>" method="POST" class="ra-form">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="room_id" value="<?php echo e($room->id); ?>">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div>
                                                <h5>Đánh giá:</h5>
                                                <select name="rating" class="form-control mb-3" style="width: auto; display: inline-block;">
                                                    <option value="5" <?php echo e(old('rating') == 5 ? 'selected' : ''); ?>>5 Sao ★★★★★</option>
                                                    <option value="4" <?php echo e(old('rating') == 4 ? 'selected' : ''); ?>>4 Sao ★★★★</option>
                                                    <option value="3" <?php echo e(old('rating') == 3 ? 'selected' : ''); ?>>3 Sao ★★★</option>
                                                    <option value="2" <?php echo e(old('rating') == 2 ? 'selected' : ''); ?>>2 Sao ★★</option>
                                                    <option value="1" <?php echo e(old('rating') == 1 ? 'selected' : ''); ?>>1 Sao ★</option>
                                                </select>
                                                <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger small" style="display: block; margin-top: -5px; margin-bottom: 15px;"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <textarea name="comment" placeholder="Nội dung đánh giá của bạn" required><?php echo e(old('comment')); ?></textarea>
                                            <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger small" style="display: block; margin-top: -15px; margin-bottom: 15px;"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <button type="submit">Gửi đánh giá</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="review-add">
                                <p style="padding: 15px; background: #f8f9fa; border-radius: 4px; color: #6c757d;">
                                    <i class="fa fa-info-circle"></i> Bạn chỉ có thể đánh giá sau khi đã hoàn thành lưu trú và trả phòng tại phòng này.
                                </p>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="review-add">
                            <p><a href="<?php echo e(route('login')); ?>">Đăng nhập</a> để gửi đánh giá của bạn.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Booking Sidebar -->
                <div class="col-lg-4">
                    <div class="room-booking" id="booking-form">
                        <h3>Đặt phòng ngay</h3>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger" style="border-radius: 4px; padding: 12px 16px; margin-bottom: 15px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
                                <ul class="mb-0" style="margin: 0; padding-left: 18px;">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li style="font-size: 13px;"><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('bookings.checkout', $room->id)); ?>" method="GET" id="booking-widget-form">
                            <div class="check-date">
                                <label for="date-in">Ngày nhận phòng:</label>
                                <input type="text" class="date-input" id="date-in" name="check_in"
                                       value="<?php echo e(request('check_in') ?? old('check_in')); ?>" placeholder="Chọn ngày nhận phòng">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Ngày trả phòng:</label>
                                <input type="text" class="date-input" id="date-out" name="check_out"
                                       value="<?php echo e(request('check_out') ?? old('check_out')); ?>" placeholder="Chọn ngày trả phòng">
                                <i class="icon_calendar"></i>
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
                            </div>
                            <div class="select-option">
                                <label for="children">Trẻ em:</label>
                                <select id="children" name="children">
                                    <?php for($i = 0; $i <= 10; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e((request('children') ?? old('children', 0)) == $i ? 'selected' : ''); ?>>
                                            <?php echo e($i); ?> Trẻ em
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            
                            <div id="capacity-warning" style="display: none; margin-top: 10px; padding: 10px; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 4px; color: #856404; font-size: 13px; font-weight: 600;">
                                <i class="fa fa-exclamation-triangle" style="margin-right: 6px;"></i>
                                <span id="capacity-warning-text"></span>
                            </div>

                            <div style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-radius: 4px;">
                                <strong>Giá: <?php echo e(number_format($room->price, 0, ',', '.')); ?> đ/đêm</strong>
                            </div>
                            <button type="submit" id="booking-submit-btn">Đặt phòng ngay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Room Details Section End -->

    
    <script>
        (function() {
            // ── Extract Room Capacity from Backend ──────────────────────────
            const maxCapacity = <?php echo e((int)$room->capacity); ?>;

            // ── DOM Elements ─────────────────────────────────────────
            const adultsSelect = document.getElementById('guest');
            const childrenSelect = document.getElementById('children');
            const submitButton = document.getElementById('booking-submit-btn');
            const warningContainer = document.getElementById('capacity-warning');
            const warningText = document.getElementById('capacity-warning-text');

            // ── Validation Function ─────────────────────────────────────
            function validateCapacity() {
                const adults = parseInt(adultsSelect.value) || 0;
                const children = parseInt(childrenSelect.value) || 0;
                const totalGuests = adults + children;

                if (totalGuests > maxCapacity) {
                    // ⚠️ EXCEED CAPACITY: Show warning + disable button
                    warningText.textContent = `Số lượng khách vượt quá sức chứa tối đa của phòng này (Tối đa ${maxCapacity} người)!`;
                    warningContainer.style.display = 'block';
                    submitButton.disabled = true;
                    submitButton.style.opacity = '0.6';
                    submitButton.style.cursor = 'not-allowed';
                } else {
                    // ✅ VALID CAPACITY: Hide warning + enable button
                    warningContainer.style.display = 'none';
                    submitButton.disabled = false;
                    submitButton.style.opacity = '1';
                    submitButton.style.cursor = 'pointer';
                }
            }

            // ── Event Listeners ───────────────────────────────────────
            adultsSelect.addEventListener('change', validateCapacity);
            childrenSelect.addEventListener('change', validateCapacity);

            // ── Initial Validation on Page Load (in case URL params exceed capacity) ──
            validateCapacity();
        })();
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/rooms/show.blade.php ENDPATH**/ ?>