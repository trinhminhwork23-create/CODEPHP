

<?php $__env->startSection('content'); ?>
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Đăng ký thành viên</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <span>Đăng ký</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Register Section Begin -->
    <section class="register-section spad">
        <style>
            .register-form {
                background: #f8f9fa;
                padding: 50px;
                border: 1px solid #ebebeb;
                border-radius: 5px;
            }
            .register-form h3 {
                color: #19191a;
                font-weight: 600;
                margin-bottom: 30px;
                text-align: center;
            }
            .register-form input[type="text"],
            .register-form input[type="email"],
            .register-form input[type="password"] {
                width: 100%;
                height: 50px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
                font-size: 16px;
                color: #19191a;
                padding-left: 20px;
                margin-bottom: 25px;
            }
            .register-form label {
                font-size: 16px;
                color: #19191a;
                font-weight: 500;
                margin-bottom: 10px;
                display: block;
            }
            .register-btn {
                background: #dfa974;
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
            .register-btn:hover {
                background: #c69463;
            }
            .register-form p {
                text-align: center;
                margin-top: 25px;
                font-size: 15px;
                color: #707079;
                margin-bottom: 0;
            }
            .register-form p a {
                color: #dfa974;
                font-weight: 500;
            }
        </style>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="register-form">
                        <h3>Đăng Ký Thành Viên</h3>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger mb-4">
                                <ul style="margin: 0; padding-left: 20px;">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('register.submit')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="name">Họ và tên <span>*</span></label>
                                <input type="text" id="name" name="name" placeholder="Nhập họ và tên đầy đủ" required value="<?php echo e(old('name')); ?>">
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
                            <div>
                                <label for="email">Địa chỉ Email <span>*</span></label>
                                <input type="email" id="email" name="email" placeholder="Nhập địa chỉ email" required value="<?php echo e(old('email')); ?>">
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
                            <div>
                                <label for="phone">Số điện thoại <span>*</span></label>
                                <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại (VD: 0901234567)" required value="<?php echo e(old('phone')); ?>">
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
                            <div>
                                <label for="password">Mật khẩu <span>*</span></label>
                                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)" required>
                                <?php $__errorArgs = ['password'];
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
                            <div>
                                <label for="password_confirmation">Xác nhận mật khẩu <span>*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                                <?php $__errorArgs = ['password_confirmation'];
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
                            <button type="submit" class="register-btn">Đăng Ký</button>
                        </form>
                        <p>Đã có tài khoản? <a href="<?php echo e(route('login')); ?>">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Register Section End -->
<?php if($errors->any() || session('error')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
    });
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/auth/register.blade.php ENDPATH**/ ?>