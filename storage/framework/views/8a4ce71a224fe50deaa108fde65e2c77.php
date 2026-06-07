

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
                                                    $isUpcoming = in_array($booking->status, [\App\Models\Booking::STATUS_DEPOSIT_PAID, \App\Models\Booking::STATUS_PAID]) && $checkInCarbon->isFuture();
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
                                                                    <span class="badge" style="background-color: #dc3545; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                                                        <i class="fa fa-exclamation-circle mr-1"></i> Chờ thanh toán
                                                                    </span>
                                                                    <?php break; ?>
                                                                <?php case (\App\Models\Booking::STATUS_DEPOSIT_PAID): ?>
                                                                    <span class="badge" style="background-color: #f39c12; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                                                        <i class="fa fa-check-circle mr-1"></i> Đã cọc 50%
                                                                    </span>
                                                                    <?php break; ?>
                                                                <?php case (\App\Models\Booking::STATUS_PAID): ?>
                                                                    <span class="badge" style="background-color: #28a745; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                                                        <i class="fa fa-check-circle-o mr-1"></i> Đã thanh toán 100%
                                                                    </span>
                                                                    <?php break; ?>
                                                                <?php case (\App\Models\Booking::STATUS_CHECKED_IN): ?>
                                                                    <span class="badge" style="background-color: #17a2b8; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                                                        <i class="fa fa-door-open mr-1"></i> Đã nhận phòng
                                                                    </span>
                                                                    <?php break; ?>
                                                                <?php case (\App\Models\Booking::STATUS_COMPLETED): ?>
                                                                    <span class="badge" style="background-color: #6c757d; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                                                        <i class="fa fa-check-square mr-1"></i> Hoàn thành
                                                                    </span>
                                                                    <?php break; ?>
                                                                <?php case (\App\Models\Booking::STATUS_CANCELLED): ?>
                                                                    <span class="badge" style="background-color: #6c757d; color: #ffffff; padding: 8px 12px; font-weight: 600; border-radius: 2px;">
                                                                        <i class="fa fa-ban mr-1"></i> Đã hủy
                                                                    </span>
                                                                    <?php break; ?>
                                                            <?php endswitch; ?>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="align-middle" style="padding: 15px 10px; vertical-align: middle;">
                                                        <div style="display: flex; flex-direction: column; gap: 10px; align-items: stretch; min-width: 200px; max-width: 220px;">
                                                            
                                                            
                                                            <a href="<?php echo e(route('bookings.show', $booking->id)); ?>" 
                                                               style="color: #555; font-weight: 600; font-size: 13px; text-decoration: none; text-align: center; padding: 6px 0; border-bottom: 2px solid #dfa974; transition: color 0.3s;" 
                                                               onmouseover="this.style.color='#dfa974'" 
                                                               onmouseout="this.style.color='#555'">
                                                                <i class="fa fa-file-text-o" style="margin-right: 5px;"></i> Xem chi tiết
                                                            </a>

                                                            
                                                            <?php if($booking->status == \App\Models\Booking::STATUS_PENDING): ?>
                                                                
                                                                
                                                                <a href="<?php echo e(route('payment.initiate', ['booking' => $booking->id, 'option' => 'full'])); ?>" 
                                                                   style="display: block; padding: 10px 16px; font-size: 13px; font-weight: 700; text-align: center; background-color: #28a745; border: none; border-radius: 3px; color: #ffffff; text-decoration: none; transition: opacity 0.3s;" 
                                                                   onmouseover="this.style.opacity='0.85'" 
                                                                   onmouseout="this.style.opacity='1'">
                                                                    <i class="fa fa-credit-card" style="margin-right: 6px;"></i> THANH TOÁN NGAY
                                                                </a>
                                                                
                                                                
                                                                <a href="<?php echo e(route('payment.initiate', ['booking' => $booking->id, 'option' => 'deposit'])); ?>" 
                                                                   style="display: block; padding: 10px 16px; font-size: 13px; font-weight: 700; text-align: center; background-color: #ff9800; border: none; border-radius: 3px; color: #ffffff; text-decoration: none; transition: opacity 0.3s;" 
                                                                   onmouseover="this.style.opacity='0.85'" 
                                                                   onmouseout="this.style.opacity='1'">
                                                                    <i class="fa fa-credit-card-alt" style="margin-right: 6px;"></i> Cọc 50%
                                                                </a>
                                                                
                                                                
                                                                <?php
                                                                    $daysUntilCheckIn = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($booking->check_in), false);
                                                                ?>

                                                                <?php if($daysUntilCheckIn >= 10): ?>
                                                                    
                                                                    <form action="<?php echo e(route('bookings.cancel', $booking->id)); ?>" method="POST" style="margin: 0;" onsubmit="return confirm('Bạn có chắc muốn hủy đơn đặt phòng này?')">
                                                                        <?php echo csrf_field(); ?>
                                                                        <button type="submit" 
                                                                                style="width: 100%; padding: 10px 16px; font-size: 13px; font-weight: 700; text-align: center; background-color: #dc3545; border: none; border-radius: 3px; color: #ffffff; cursor: pointer; transition: opacity 0.3s;" 
                                                                                onmouseover="this.style.opacity='0.85'" 
                                                                                onmouseout="this.style.opacity='1'">
                                                                            <i class="fa fa-times-circle" style="margin-right: 6px;"></i> Hủy đơn
                                                                        </button>
                                                                    </form>
                                                                <?php else: ?>
                                                                    
                                                                    <div style="padding: 10px 12px; font-size: 12px; font-weight: 600; text-align: center; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 3px; color: #856404;">
                                                                        <i class="fa fa-ban" style="margin-right: 6px;"></i> Không thể hủy (Sát ngày nhận phòng dưới 10 ngày)
                                                                    </div>
                                                                <?php endif; ?>

                                                            
                                                            <?php elseif($booking->status == \App\Models\Booking::STATUS_DEPOSIT_PAID): ?>
                                                                
                                                                <a href="<?php echo e(route('payment.initiate', ['booking' => $booking->id, 'option' => 'deposit'])); ?>" 
                                                                   style="display: block; padding: 10px 16px; font-size: 13px; font-weight: 700; text-align: center; background-color: #007bff; border: none; border-radius: 3px; color: #ffffff; text-decoration: none; transition: opacity 0.3s;" 
                                                                   onmouseover="this.style.opacity='0.85'" 
                                                                   onmouseout="this.style.opacity='1'">
                                                                    <i class="fa fa-credit-card" style="margin-right: 6px;"></i> Thanh toán 50% còn lại
                                                                </a>
                                                                
                                                                
                                                                <?php
                                                                    $daysUntilCheckIn = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($booking->check_in), false);
                                                                ?>

                                                                <?php if($daysUntilCheckIn >= 10): ?>
                                                                    
                                                                    <form action="<?php echo e(route('bookings.cancel', $booking->id)); ?>" method="POST" style="margin: 0;" onsubmit="return confirm('Bạn có chắc muốn hủy đơn đặt phòng này?')">
                                                                        <?php echo csrf_field(); ?>
                                                                        <button type="submit" 
                                                                                style="width: 100%; padding: 10px 16px; font-size: 13px; font-weight: 700; text-align: center; background-color: #dc3545; border: none; border-radius: 3px; color: #ffffff; cursor: pointer; transition: opacity 0.3s;" 
                                                                                onmouseover="this.style.opacity='0.85'" 
                                                                                onmouseout="this.style.opacity='1'">
                                                                            <i class="fa fa-times-circle" style="margin-right: 6px;"></i> Hủy đơn
                                                                        </button>
                                                                    </form>
                                                                <?php else: ?>
                                                                    
                                                                    <div style="padding: 10px 12px; font-size: 12px; font-weight: 600; text-align: center; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 3px; color: #856404;">
                                                                        <i class="fa fa-ban" style="margin-right: 6px;"></i> Không thể hủy (Sát ngày nhận phòng dưới 10 ngày)
                                                                    </div>
                                                                <?php endif; ?>

                                                            
                                                            <?php elseif($booking->status == \App\Models\Booking::STATUS_PAID): ?>
                                                                
                                                                <span style="display: block; padding: 10px; font-size: 12px; color: #28a745; text-align: center; font-weight: 600; font-style: italic;">
                                                                    <i class="fa fa-clock-o mr-1"></i> Chờ nhận phòng
                                                                </span>

                                                            
                                                            <?php elseif($booking->status == \App\Models\Booking::STATUS_CHECKED_IN): ?>
                                                                
                                                                <span style="display: block; padding: 10px; font-size: 12px; color: #17a2b8; text-align: center; font-weight: 600; font-style: italic;">
                                                                    <i class="fa fa-bed mr-1"></i> Đang lưu trú
                                                                </span>

                                                            
                                                            <?php elseif($booking->status == \App\Models\Booking::STATUS_COMPLETED): ?>
                                                                
                                                                <a href="<?php echo e(route('rooms.show', $booking->room_id)); ?>#reviews" 
                                                                   style="display: block; padding: 9px 16px; font-size: 13px; font-weight: 600; text-align: center; background-color: transparent; border: 2px solid #dfa974; border-radius: 3px; color: #dfa974; text-decoration: none; transition: all 0.3s;" 
                                                                   onmouseover="this.style.backgroundColor='#dfa974'; this.style.color='#ffffff'" 
                                                                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dfa974'">
                                                                    <i class="fa fa-star-o" style="margin-right: 6px;"></i> Viết đánh giá
                                                                </a>

                                                            
                                                            <?php elseif($booking->status == \App\Models\Booking::STATUS_CANCELLED): ?>
                                                                
                                                                <span style="display: block; padding: 10px; font-size: 12px; color: #999; text-align: center; font-style: italic;">
                                                                    Không có thao tác
                                                                </span>

                                                            <?php endif; ?>
                                                        </div>
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