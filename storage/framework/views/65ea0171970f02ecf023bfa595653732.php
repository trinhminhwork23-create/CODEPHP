<div class="top-nav">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <ul class="tn-left">
                    <li><i class="fa fa-phone"></i> 0214.371.9999</li>
                    <li><i class="fa fa-envelope"></i> booking@sapajadehill.vn</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="tn-right">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(in_array(auth()->user()->role, ['admin', 'staff'])): ?>
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="bk-btn">Trang quản lý</a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('profile.history')); ?>" class="bk-btn">Đơn hàng của tôi</a>
                        <div class="language-option">
                            <span><?php echo e(auth()->user()->name); ?> <i class="fa fa-angle-down"></i></span>
                            <div class="flag-dropdown dropdown-menu-custom">
                                <ul>
                                    <li><a href="<?php echo e(route('profile.history')); ?>">Quản lý tài khoản</a></li>
                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
                                </ul>
                            </div>
                        </div>
                        <form id="logout-form" action="<?php echo e(route('auth.logout')); ?>" method="POST" style="display:none;"><?php echo csrf_field(); ?></form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="bk-btn">Đăng nhập</a>
                        <a href="<?php echo e(route('register')); ?>" class="bk-btn">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="menu-item">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="logo">
                    <a href="<?php echo e(url('/')); ?>">
                        <img src="<?php echo e(asset('img/logojadehill.png')); ?>" alt="Sapa Jade Hill" style="max-height: 60px;">
                    </a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="nav-menu">
                    <ul class="mainmenu">
                        <li class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
                        <li class="<?php echo e(request()->routeIs('rooms.*') ? 'active' : ''); ?>"><a href="<?php echo e(route('rooms.index')); ?>">Phòng nghỉ</a></li>
                        <li class="<?php echo e(request()->routeIs('about') ? 'active' : ''); ?>"><a href="<?php echo e(route('about')); ?>">Giới thiệu</a></li>
                        <li class="<?php echo e(request()->routeIs('blog.*') ? 'active' : ''); ?>"><a href="<?php echo e(route('blog.index')); ?>">Tin tức</a></li>
                        <li class="<?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>"><a href="<?php echo e(route('contact')); ?>">Liên hệ</a></li>
                    </ul>
                    <div class="nav-right">
                        <div class="nav-search-container sapa-nav-search-container">
                            <form action="<?php echo e(route('rooms.index')); ?>" method="GET" class="nav-search-form">
                                <input 
                                    type="text" 
                                    id="navbar-search-input" 
                                    name="search"
                                    placeholder="Tìm phòng..."
                                    autocomplete="off"
                                    class="sapa-search-input"
                                >
                                <button type="submit" class="sapa-search-btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                            <div id="search-suggestion-wrapper"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dropdown-menu-custom {
    min-width: 180px !important;
    white-space: nowrap;
}
.dropdown-menu-custom ul li a {
    display: block;
    padding: 10px 15px;
    white-space: nowrap;
}
.dropdown-menu-custom ul li a:hover {
    background-color: #f5f5f5;
}
</style>

<?php $__env->startPush('scripts'); ?>
<script>
    window.roomsSuggestionsUrl = "<?php echo e(route('rooms.suggestions')); ?>";
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/layouts/header.blade.php ENDPATH**/ ?>