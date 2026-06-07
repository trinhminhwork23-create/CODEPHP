<?php $__env->startSection('content'); ?>

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-text">
                        <h2>Thông tin liên hệ</h2>
                        <p>Vui lòng để lại thông tin hoặc liên hệ với chúng tôi qua các kênh dưới đây. Sapa Jade Hill Resort & Spa luôn sẵn lòng hỗ trợ bạn mọi lúc mọi nơi.</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="c-o">Địa chỉ:</td>
                                    <td>Thung lũng Mường Hoa, Ngõ Cầu Mây, Tổ 3, Phường Cầu Mây, Thị xã Sa Pa, Tỉnh Lào Cai, Việt Nam.</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Điện thoại:</td>
                                    <td>0214.371.9999</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Email:</td>
                                    <td>booking@sapajadehill.vn</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Hotline:</td>
                                    <td>0214.371.9999</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success sapa-contact-alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger sapa-contact-alert-danger">
                            <ul class="sapa-contact-error-list">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo e(route('contact.store')); ?>" method="POST" class="contact-form">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name" placeholder="Họ và tên" value="<?php echo e(old('name')); ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" placeholder="Địa chỉ Email" value="<?php echo e(old('email')); ?>" required>
                            </div>
                            <div class="col-lg-12">
                                <textarea name="message" placeholder="Lời nhắn của bạn" required><?php echo e(old('message')); ?></textarea>
                                <button type="submit">Gửi thông tin</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3711.666996615783!2d103.85040661539268!3d22.32757278531093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x36cd410d7a00dcd9%3A0xc3fa19b0d2d31be0!2sSapa%20Jade%20Hill%20Resort!5e0!3m2!1svi!2svn!4v1623089000000!5m2!1svi!2svn"
                    height="470" style="border:0;" allowfullscreen=""></iframe>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .sapa-contact-alert-success {
        padding: 15px;
        margin-bottom: 20px;
        background: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 4px;
        color: #155724;
    }
    .sapa-contact-alert-danger {
        padding: 15px;
        margin-bottom: 20px;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 4px;
        color: #721c24;
    }
    .sapa-contact-error-list {
        margin: 0;
        padding-left: 20px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/contact.blade.php ENDPATH**/ ?>