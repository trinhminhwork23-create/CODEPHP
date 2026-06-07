

<?php $__env->startSection('content'); ?>
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Đăng nhập thành viên</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <span>Đăng nhập</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Login Section Begin -->
    <section class="login-section spad">
        <style>
            .login-form {
                background: #f8f9fa;
                padding: 50px;
                border: 1px solid #ebebeb;
                border-radius: 5px;
            }
            .login-form h3 {
                color: #19191a;
                font-weight: 600;
                margin-bottom: 30px;
                text-align: center;
            }
            .login-form input[type="text"],
            .login-form input[type="email"],
            .login-form input[type="password"] {
                width: 100%;
                height: 50px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
                font-size: 16px;
                color: #19191a;
                padding-left: 20px;
                margin-bottom: 25px;
            }
            .login-form label {
                font-size: 16px;
                color: #19191a;
                font-weight: 500;
                margin-bottom: 10px;
                display: block;
            }
            .login-btn {
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
            .login-btn:hover {
                background: #c69463;
            }
            .login-form p {
                text-align: center;
                margin-top: 25px;
                font-size: 15px;
                color: #707079;
                margin-bottom: 0;
            }
            .login-form p a {
                color: #dfa974;
                font-weight: 500;
            }
        </style>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form">
                        <h3>Đăng Nhập</h3>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger mb-4">
                                <ul style="margin: 0; padding-left: 20px;">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('auth.login.submit')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="login_field">Email hoặc Số điện thoại <span>*</span></label>
                                <input type="text" id="login_field" name="login_field" placeholder="Nhập email hoặc số điện thoại" required value="<?php echo e(old('login_field')); ?>">
                                <?php $__errorArgs = ['login_field'];
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
                                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
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
                            <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: -10px;">
                                <a href="<?php echo e(route('password.request')); ?>" style="color: #dfa974; font-size: 15px; font-weight: 500;">Quên mật khẩu?</a>
                            </div>
                            <button type="submit" class="login-btn">Đăng Nhập</button>
                        </form>
                        <p>Chưa có tài khoản? <a href="<?php echo e(route('register')); ?>">Đăng ký thành viên ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\CODEPHP\resources\views/auth/login.blade.php ENDPATH**/ ?>