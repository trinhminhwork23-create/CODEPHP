<?php $__env->startSection('content'); ?>
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Quản lý tài khoản</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <span>Quản lý tài khoản</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Profile Section Begin -->
    <section class="profile-section spad">
        <style>
            .profile-tabs .nav-tabs {
                border-bottom: 2px solid #dfa974;
                gap: 5px;
            }
            .profile-tabs .nav-link {
                border: none;
                border-bottom: 3px solid transparent;
                background: none;
                color: #707079;
                font-weight: 600;
                font-size: 16px;
                padding: 12px 25px;
                transition: all 0.3s;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .profile-tabs .nav-link:hover {
                color: #dfa974;
                border-color: transparent;
            }
            .profile-tabs .nav-link.active {
                border-color: #dfa974 !important;
                color: #dfa974 !important;
                background: #fdfaf6 !important;
            }
            .form-group label {
                font-weight: 600;
                color: #19191a;
                margin-bottom: 8px;
                font-size: 15px;
            }
            .form-control {
                height: 48px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
                padding-left: 20px;
                font-size: 15px;
                color: #19191a;
                transition: all 0.3s;
            }
            .form-control:focus {
                border-color: #dfa974;
                box-shadow: none;
                outline: none;
            }
            .form-control:disabled, .form-control[readonly] {
                background-color: #f8f9fa;
                opacity: 0.8;
                color: #707079;
            }
            .profile-card {
                border: 1px solid #ebebeb;
                border-radius: 2px;
                background: #ffffff;
                box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            }
        </style>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Flash Message Block -->
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 2px; font-weight: 500;">
                            <i class="fa fa-check-circle mr-2"></i> <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 2px; font-weight: 500;">
                            <i class="fa fa-exclamation-circle mr-2"></i> <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="profile-tabs mb-5">
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="bookings-tab" data-toggle="tab" data-bs-toggle="tab" href="#bookings" data-bs-target="#bookings" role="tab" aria-controls="bookings" aria-selected="true">
                                    <i class="fa fa-calendar-check-o mr-2"></i> Đặt phòng & Chờ nhận
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" data-bs-toggle="tab" href="#profile" data-bs-target="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                    <i class="fa fa-user-circle mr-2"></i> Thông tin cá nhân
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="security-tab" data-toggle="tab" data-bs-toggle="tab" href="#security" data-bs-target="#security" role="tab" aria-controls="security" aria-selected="false">
                                    <i class="fa fa-shield mr-2"></i> Bảo mật & Mật khẩu
                                </a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="profileTabContent">
                            <!-- TAB 1: LỊCH SỬ ĐẶT PHÒNG & PHÒNG CHỜ NHẬN -->
                            <div class="tab-pane fade show active" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                                <div class="table-responsive profile-card p-4">
                                    <h4 class="mb-4" style="font-weight: 600; color: #19191a; border-left: 4px solid #dfa974; padding-left: 10px;">Lịch sử giao dịch</h4>
                                    <table class="table table-bordered table-hover text-center mb-0" style="border: 1px solid #ebebeb;">
                                        <thead style="background-color: #dfa974; color: #ffffff;">
                                            <tr>
                                                <th style="font-weight: 500; padding: 15px;">Mã đơn</th>
                                                <th style="font-weight: 500; padding: 15px;">Tên phòng</th>
                                                <th style="font-weight: 500; padding: 15px;">Ngày nhận</th>
                                                <th style="font-weight: 500; padding: 15px;">Ngày trả</th>
                                                <th style="font-weight: 500; padding: 15px;">Tổng tiền</th>
                                                <th style="font-weight: 500; padding: 15px;">Trạng thái</th>
                                                <th style="font-weight: 500; padding: 15px;">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <?php
                                                    $checkInCarbon = \Carbon\Carbon::parse($booking->check_in);
                                                    $isUpcoming = in_array($booking->status, [\App\Models\Booking::STATUS_APPROVED, \App\Models\Booking::STATUS_PAID]) && $checkInCarbon->isFuture();
                                                ?>
                                                <tr>
                                                    <td class="align-middle" style="color: #19191a; font-weight: 600; font-size: 14px;">
                                                        SJD-<?php echo e(str_pad($booking->id, 6, '0', STR_PAD_LEFT)); ?>

                                                    </td>
                                                    
                                                    <td class="align-middle" style="color: #19191a; font-weight: 500;"><?php echo e($booking->room->name ?? 'N/A'); ?></td>
                                                    
                                                    <td class="align-middle" style="color: #707079;"><?php echo e($checkInCarbon->format('d/m/Y')); ?></td>
                                                    
                                                    <td class="align-middle" style="color: #707079;"><?php echo e(\Carbon\Carbon::parse($booking->check_out)->format('d/m/Y')); ?></td>
                                                    
                                                    <td class="align-middle" style="color: #dfa974; font-weight: 600;">
                                                        <?php echo e(number_format($booking->total_money, 0, ',', '.')); ?>₫
                                                    </td>

                                                    <td class="align-middle">
                                                        <?php if($isUpcoming): ?>
                                                            <span class="badge" style="background-color: #28a745; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                                                <i class="fa fa-clock-o mr-1"></i> Chờ nhận phòng
                                                            </span>
                                                        <?php else: ?>
                                                            <?php switch($booking->status):
                                                                case (\App\Models\Booking::STATUS_PENDING): ?>
                                                                    <span class="badge" style="background-color: #ffc107; color: #212529; padding: 8px 12px; font-weight: 600; border-radius: 2px;">Chờ duyệt</span> 
                                                                    <?php break; ?>
                                                                <?php case (\App\Models\Booking::STATUS_APPROVED): ?>
                                                                    <span class="badge" style="background-color: #17a2b8; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">Đã cọc 50%</span> 
                                                                    <?php break; ?>
                                                                <?php case (\App\Models\Booking::STATUS_PAID): ?>
                                                                    <span class="badge" style="background-color: #6c757d; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">Đã hoàn thành</span> 
                                                                    <?php break; ?>
                                                                <?php case (\App\Models\Booking::STATUS_CANCELLED): ?>
                                                                    <span class="badge" style="background-color: #dc3545; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">Đã hủy</span> 
                                                                    <?php break; ?>
                                                            <?php endswitch; ?>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="align-middle">
                                                        <?php if($booking->status == \App\Models\Booking::STATUS_PAID): ?>
                                                            <a href="<?php echo e(route('rooms.show', $booking->room_id)); ?>#reviews" class="primary-btn" style="padding: 8px 18px; font-size: 13px; border-radius: 2px;">Đánh giá</a>
                                                        <?php elseif($booking->status == \App\Models\Booking::STATUS_APPROVED): ?>
                                                            <div class="d-flex flex-column gap-1 align-items-center">
                                                                <a href="<?php echo e(route('payment.initiate', ['booking' => $booking->id, 'option' => 'deposit'])); ?>" class="btn btn-sm btn-primary text-white fw-semibold mb-1" style="padding: 8px 12px; font-size: 12px; border-radius: 2px; background-color: #005a9c; border-color: #005a9c;">Thanh toán 50% còn lại</a>
                                                                <form action="<?php echo e(route('bookings.cancel', $booking->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn hủy đơn đặt phòng này?')">
                                                                    <?php echo csrf_field(); ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 6px 12px; font-size: 12px; border-radius: 2px;">Hủy đơn</button>
                                                                </form>
                                                            </div>
                                                        <?php elseif($booking->status == \App\Models\Booking::STATUS_PENDING): ?>
                                                            <form action="<?php echo e(route('bookings.cancel', $booking->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn hủy đơn đặt phòng này?')">
                                                                <?php echo csrf_field(); ?>
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 8px 15px; font-size: 12px; border-radius: 2px;">Hủy đơn</button>
                                                            </form>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-5" style="color: #707079; font-size: 15px;">
                                                        <i class="fa fa-info-circle mr-2" style="font-size: 18px;"></i> Hiện tại quý khách chưa thực hiện đơn đặt phòng nào.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 2: THÔNG TIN CÁ NHÂN (Profile Settings) -->
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="profile-card p-4">
                                    <h4 class="mb-4" style="font-weight: 600; color: #19191a; border-left: 4px solid #dfa974; padding-left: 10px;">Thay đổi thông tin hồ sơ</h4>
                                    
                                    <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>

                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name">Họ và tên <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" placeholder="Nhập họ và tên..." required>
                                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger small mt-1 d-block"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label for="email">Địa chỉ Email (Đăng nhập - Không thể thay đổi)</label>
                                                    <input type="email" class="form-control" id="email" value="<?php echo e(auth()->user()->email); ?>" disabled readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone" name="phone" value="<?php echo e(old('phone', auth()->user()->phone ?? '')); ?>" placeholder="Nhập số điện thoại..." required>
                                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger small mt-1 d-block"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 text-right">
                                            <button type="submit" class="primary-btn" style="border: none; padding: 12px 30px; border-radius: 2px;">Cập nhật thông tin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- TAB 3: ĐỔI MẬT KHẨU (Security Settings) -->
                            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <div class="profile-card p-4" style="max-width: 650px; margin: 0 auto;">
                                    <h4 class="mb-4" style="font-weight: 600; color: #19191a; border-left: 4px solid #dfa974; padding-left: 10px;">Thiết lập mật khẩu mới</h4>
                                    
                                    <form action="<?php echo e(route('profile.password.update')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>

                                        <div class="form-group mb-3">
                                            <label for="current_password">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="current_password" name="current_password" placeholder="Nhập mật khẩu hiện tại..." required>
                                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger small mt-1 d-block"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password">Mật khẩu mới <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" placeholder="Mật khẩu mới ít nhất 6 ký tự..." required>
                                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger small mt-1 d-block"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="password_confirmation">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận lại mật khẩu mới..." required>
                                        </div>

                                        <div class="mt-4 text-right">
                                            <button type="submit" class="primary-btn" style="border: none; padding: 12px 30px; border-radius: 2px; background-color: #dfa974;">Đổi mật khẩu</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Profile Section End -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    window.addEventListener('load', function() {
        <?php if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation')): ?>
            var securityTab = document.querySelector('#security-tab');
            if (securityTab) {
                if (window.bootstrap && bootstrap.Tab) {
                    new bootstrap.Tab(securityTab).show();
                } else if (window.jQuery) {
                    jQuery(securityTab).tab('show');
                }
            }
        <?php elseif($errors->has('name') || $errors->has('phone')): ?>
            var profileTab = document.querySelector('#profile-tab');
            if (profileTab) {
                if (window.bootstrap && bootstrap.Tab) {
                    new bootstrap.Tab(profileTab).show();
                } else if (window.jQuery) {
                    jQuery(profileTab).tab('show');
                }
            }
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/profile/history.blade.php ENDPATH**/ ?>