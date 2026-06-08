

<?php $__env->startSection('content'); ?>
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Khôi phục mật khẩu</h2>
                        <div class="bt-option">
                            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                            <span>Quên mật khẩu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Password Recovery Section Begin -->
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
                margin-bottom: 20px;
                text-align: center;
            }
            .login-form input[type="email"] {
                width: 100%;
                height: 50px;
                border: 1px solid #ebebeb;
                border-radius: 2px;
                font-size: 16px;
                color: #19191a;
                padding-left: 20px;
                margin-bottom: 5px;
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
                margin-top: 15px;
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
                        <h3>Quên mật khẩu?</h3>
                        <p class="text-center mb-4" style="font-size: 14px;">Vui lòng điền địa chỉ email đăng ký tài khoản của bạn để nhận mã OTP.</p>
                        
                        <?php if(session('status')): ?>
                            <div class="alert alert-success mb-4 text-center">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('password.email')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="email">Địa chỉ Email <span>*</span></label>
                                <input type="email" id="email" name="email" placeholder="Nhập địa chỉ email đăng ký" required value="<?php echo e(old('email')); ?>">
                                <?php $__errorArgs = ['email'];
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
                            <button type="submit" class="login-btn">Gửi mã OTP</button>
                        </form>
                        <p><a href="<?php echo e(route('login')); ?>">Quay lại trang Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Password Recovery Section End -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>