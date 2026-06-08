

<?php $__env->startSection('content'); ?>
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Xác nhận OTP</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <span>Xác nhận OTP</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="login-section spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form">
                        <h3>Nhập mã OTP</h3>
                        <p class="text-center mb-4" style="font-size:14px;">
                            Mã OTP đã được gửi đến <strong><?php echo e(session('reset_email')); ?></strong>
                        </p>

                        <?php if(session('status')): ?>
                            <div class="alert alert-success mb-4 text-center"><?php echo e(session('status')); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('password.verify')); ?>">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="email">Địa chỉ Email</label>
                                <input type="email" value="<?php echo e(session('reset_email')); ?>" readonly
                                    style="width:100%;height:50px;border:1px solid #ebebeb;padding-left:20px;background:#e9ecef;font-size:16px;">
                            </div>
                            <div style="margin-top:20px;">
                                <label for="otp">Mã OTP <span>*</span></label>
                                <input type="text" id="otp" name="otp" placeholder="Nhập mã 6 số"
                                    maxlength="6" required value="<?php echo e(old('otp')); ?>"
                                    style="width:100%;height:50px;border:1px solid #ebebeb;padding-left:20px;font-size:16px;">
                                <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small" style="display:block;margin-top:5px;"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <button type="submit" class="login-btn" style="margin-top:20px;">Xác nhận OTP</button>
                        </form>
                        <p style="text-align:center;margin-top:20px;">
                        <form method="POST" action="<?php echo e(route('password.resend')); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" style="background:none;border:none;color:#dfa974;font-weight:500;cursor:pointer;padding:0;font-size:inherit;">Gửi lại mã OTP</button>
                            </form>
                            &nbsp;|&nbsp;
                            <a href="<?php echo e(route('login')); ?>" style="color:#dfa974;">Quay lại Đăng nhập</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/auth/passwords/verify.blade.php ENDPATH**/ ?>