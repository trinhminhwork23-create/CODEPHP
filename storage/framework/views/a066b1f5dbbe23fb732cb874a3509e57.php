

<?php $__env->startSection('content'); ?>
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Thanh toán</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <a href="<?php echo e(route('rooms.index')); ?>">Phòng nghỉ</a>
                            <span>Thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout-section spad">
        
        <?php if(session('error')): ?>
            <div class="container mb-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi:</strong> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="container mb-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Vui lòng kiểm tra lại thông tin:</strong>
                    <ul class="mb-0 mt-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>
        <style>
            .checkout-form input[type="text"],
            .checkout-form input[type="email"],
            .checkout-form textarea {
                width: 100%;
                height: 50px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
                font-size: 16px;
                color: #19191a;
                padding-left: 20px;
                margin-bottom: 25px;
            }
            .checkout-form textarea {
                height: 150px;
                padding-top: 15px;
            }
            .checkout-form label {
                font-size: 16px;
                color: #19191a;
                font-weight: 500;
                margin-bottom: 10px;
                display: block;
            }
            .checkout-order {
                background: #f8f9fa;
                padding: 40px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
            }
            .checkout-order h4 {
                color: #19191a;
                font-weight: 600;
                margin-bottom: 25px;
                border-bottom: 1px solid #ebebeb;
                padding-bottom: 15px;
            }
            .checkout-order ul {
                list-style: none;
                margin-bottom: 25px;
            }
            .checkout-order ul li {
                font-size: 16px;
                color: #707079;
                line-height: 40px;
                display: flex;
                justify-content: space-between;
            }
            .checkout-order ul li span {
                color: #19191a;
                font-weight: 500;
            }
            .checkout-order .checkout-total {
                border-top: 1px solid #ebebeb;
                padding-top: 20px;
                margin-bottom: 25px;
            }
            .checkout-order .checkout-total li {
                font-size: 18px;
                color: #19191a;
                font-weight: 600;
            }
            .checkout-order .checkout-total li span {
                color: #dfa974;
            }
            .vnpay-btn {
                background: #005a9c;
                color: #ffffff;
                font-size: 16px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 2px;
                width: 100%;
                border: none;
                padding: 14px 0 12px;
                border-radius: 2px;
                cursor: pointer;
                transition: all 0.3s;
            }
            .vnpay-btn:hover {
                background: #00467a;
            }
        </style>
        <div class="container">
            <form action="<?php echo e(route('booking.confirm')); ?>" method="POST" class="checkout-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="room_id" value="<?php echo e($room->id); ?>">

                <div class="row">
                    <div class="col-lg-7">
                        <div class="checkout-content">
                            <h4 style="margin-bottom: 30px; font-weight: 600;">Thông tin khách hàng</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="name">Họ và tên <span>*</span></label>
                                    <input type="text" id="name" name="name" value="<?php echo e(Auth::user()->name); ?>" readonly required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger small" style="display: block; margin-top: -20px; margin-bottom: 15px;"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-lg-6">
                                    <label for="email">Địa chỉ Email <span>*</span></label>
                                    <input type="email" id="email" name="email" value="<?php echo e(Auth::user()->email); ?>" readonly required>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger small" style="display: block; margin-top: -20px; margin-bottom: 15px;"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-lg-6">
                                    <label for="phone">Số điện thoại <span>*</span></label>
                                    <input type="text" id="phone" name="phone" value="<?php echo e(Auth::user()->phone ?? old('phone')); ?>" placeholder="Nhập số điện thoại..." required>
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger small" style="display: block; margin-top: -20px; margin-bottom: 15px;"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-lg-12">
                                    <label for="note">Ghi chú thêm</label>
                                    <textarea id="note" name="comment" placeholder="Yêu cầu đặc biệt..."><?php echo e(old('comment')); ?></textarea>
                                    <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger small" style="display: block; margin-top: -20px; margin-bottom: 15px;"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="checkout-order">
                            <h4>Thông tin đặt phòng</h4>
                            <ul>
                                <li>Phòng <span><?php echo e($room->name); ?></span></li>
                                <li>Ngày nhận phòng 
                                    <span>
                                        <?php echo e(\Carbon\Carbon::parse($data['check_in'])->format('d/m/Y')); ?>

                                        <input type="hidden" name="check_in" value="<?php echo e($data['check_in']); ?>">
                                    </span>
                                </li>
                                <li>Ngày trả phòng 
                                    <span>
                                        <?php echo e(\Carbon\Carbon::parse($data['check_out'])->format('d/m/Y')); ?>

                                        <input type="hidden" name="check_out" value="<?php echo e($data['check_out']); ?>">
                                    </span>
                                </li>
                                <li>Người lớn 
                                    <span>
                                        <?php echo e($data['adults'] ?? 1); ?> người lớn
                                        <input type="hidden" name="adults" value="<?php echo e($data['adults'] ?? 1); ?>">
                                    </span>
                                </li>
                                <li>Trẻ em 
                                    <span>
                                        <?php echo e($data['children'] ?? 0); ?> trẻ em
                                        <input type="hidden" name="children" value="<?php echo e($data['children'] ?? 0); ?>">
                                    </span>
                                </li>
                            </ul>
                            <div class="checkout-total">
                                <ul>
                                    <li>Tổng tiền <span><?php echo e(number_format($totalPrice, 0, ',', '.')); ?> VNĐ</span></li>
                                    <li>Tiền cọc (50%) <span><?php echo e(number_format($totalPrice / 2, 0, ',', '.')); ?> VNĐ</span></li>
                                </ul>
                            </div>
                            <div class="payment-option mb-4">
                                <label style="font-weight: 600; color: #19191a; margin-bottom: 10px; display: block;">Hình thức thanh toán:</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_option" id="pay-deposit" value="deposit" checked style="height: auto; width: auto; margin-right: 5px;">
                                    <label class="form-check-label" for="pay-deposit" style="display: inline; cursor: pointer; font-size: 15px; color: #707079;">
                                        Đặt cọc trước 50% (<?php echo e(number_format($totalPrice * 0.5, 0, ',', '.')); ?> VNĐ)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_option" id="pay-full" value="full" style="height: auto; width: auto; margin-right: 5px;">
                                    <label class="form-check-label" for="pay-full" style="display: inline; cursor: pointer; font-size: 15px; color: #707079;">
                                        Thanh toán toàn bộ 100% (<?php echo e(number_format($totalPrice, 0, ',', '.')); ?> VNĐ)
                                    </label>
                                </div>
                                <?php $__errorArgs = ['payment_option'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small" style="display: block; margin-top: 5px;"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="payment-method">
                                <p style="font-size: 14px; color: #707079; margin-bottom: 20px;">
                                    * Quý khách sẽ được chuyển hướng đến cổng thanh toán VNPAY để thực hiện giao dịch an toàn.
                                </p>
                                <button type="submit" class="vnpay-btn">Thanh toán qua VNPAY</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Section End -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/bookings/checkout.blade.php ENDPATH**/ ?>