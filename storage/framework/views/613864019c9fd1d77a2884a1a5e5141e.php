<aside id="sidebar" class="sidebar">

    <ul class="nav flex-column">
        <li class="px-4 py-2"><small class="nav-text">Quản lý chính</small></li>
        <li><a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-home"></i><span class="nav-text">Bảng điều khiển tổng quan</span></a></li>
        <li><a class="nav-link <?php echo e(request()->routeIs('admin.rooms.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.rooms.index')); ?>"><i class="ti ti-bed"></i><span class="nav-text">Quản lý phòng</span></a></li>
        <li><a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>"><i class="ti ti-category"></i><span class="nav-text">Loại phòng</span></a></li>
        <li><a class="nav-link <?php echo e(request()->routeIs('admin.bookings.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.bookings.index')); ?>"><i class="ti ti-calendar-event"></i><span class="nav-text">Đơn đặt phòng</span></a></li>
        <li><a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users.index')); ?>"><i class="ti ti-users"></i><span class="nav-text">Tài khoản</span></a></li>
        <li><a class="nav-link <?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.reviews.index')); ?>"><i class="ti ti-star"></i><span class="nav-text">Đánh giá</span></a></li>
        <li><a class="nav-link <?php echo e(request()->routeIs('admin.logs.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.logs.index')); ?>"><i class="ti ti-history"></i><span class="nav-text">Nhật ký hệ thống</span></a></li>
        <li class="px-4 pt-4 pb-2"><small class="nav-text">Tài khoản</small></li>
        <li><a class="nav-link" href="<?php echo e(route('home')); ?>"><i class="ti ti-world"></i><span class="nav-text">Về trang chủ</span></a></li>
        <li>
            <form method="POST" action="<?php echo e(route('auth.logout')); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <a class="nav-link" href="<?php echo e(route('auth.logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();"><i class="ti ti-logout"></i><span class="nav-text">Đăng xuất</span></a>
            </form>
        </li>
    </ul>
</aside>


<?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/admin/layouts/admin_sidebar.blade.php ENDPATH**/ ?>