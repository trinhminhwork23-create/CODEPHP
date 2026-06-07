<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Resort – Khu nghỉ dưỡng cao cấp, đặt phòng trực tuyến nhanh chóng và tiện lợi.">
    <meta name="keywords" content="Sona, khu nghỉ dưỡng, đặt phòng, khách sạn, resort, nghỉ dưỡng">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sona Resort – Nghỉ dưỡng sang trọng</title>

    <!-- Google Fonts: Inter (Vietnamese subset) – must load FIRST to override fallback fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@400;700&family=Cabin:wght@400;500;600;700&subset=vietnamese&display=swap" rel="stylesheet">
    <style>
        /* Vietnamese font override – ensure diacritics render correctly */
        body, h1, h2, h3, h4, h5, h6, p, a, span, button, input { font-family: 'Inter', sans-serif !important; }
    </style>

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome.min.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/elegant-icons.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/flaticon.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/owl.carousel.min.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/nice-select.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/jquery-ui.min.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/magnific-popup.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/slicknav.min.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="canvas-open">
        <i class="icon_menu"></i>
    </div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="icon_close"></i>
        </div>
        <div class="search-icon  search-switch">
            <i class="icon_search"></i>
        </div>
        <div class="header-configure-area">
            <div class="language-option">
                <img src="<?php echo e(asset('img/flag.jpg')); ?>" alt="">
                <span>VI <i class="fa fa-angle-down"></i></span>
                <div class="flag-dropdown">
                    <ul>
                        <li><a href="#">EN</a></li>
                        <li><a href="#">Fr</a></li>
                    </ul>
                </div>
            </div>
            <a href="<?php echo e(route('rooms.index')); ?>" class="bk-btn">Đặt phòng ngay</a>
        </div>
        <nav class="mainmenu mobile-menu">
            <ul>
                <li class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
                <li class="<?php echo e(request()->routeIs('rooms.*') ? 'active' : ''); ?>"><a href="<?php echo e(route('rooms.index')); ?>">Phòng nghỉ</a></li>
                <li class="<?php echo e(request()->routeIs('about') ? 'active' : ''); ?>"><a href="<?php echo e(route('about')); ?>">Giới thiệu</a></li>
                <li><a href="#">Trang</a>
                    <ul class="dropdown">
                        <li><a href="<?php echo e(route('rooms.show', 1)); ?>">Chi tiết phòng</a></li>
                        <li><a href="<?php echo e(route('rooms.show', 2)); ?>">Phòng Deluxe</a></li>
                        <li><a href="<?php echo e(route('rooms.show', 3)); ?>">Phòng Gia đình</a></li>
                        <li><a href="<?php echo e(route('rooms.show', 4)); ?>">Phòng Cao cấp</a></li>
                    </ul>
                </li>
                <li class="<?php echo e(request()->routeIs('blog.*') ? 'active' : ''); ?>"><a href="<?php echo e(route('blog.index')); ?>">Tin tức</a></li>
                <li class="<?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>"><a href="<?php echo e(route('contact')); ?>">Liên hệ</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="top-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-tripadvisor"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <ul class="top-widget">
            <li><i class="fa fa-phone"></i> (12) 345 67890</li>
            <li><i class="fa fa-envelope"></i> info.colorlib@gmail.com</li>
        </ul>
    </div>
    <!-- Offcanvas Menu Section End -->

    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Tìm kiếm tại đây.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="<?php echo e(asset('js/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.magnific-popup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.nice-select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.slicknav.js')); ?>"></script>
    <script src="<?php echo e(asset('js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
</body>

</html>
<?php /**PATH D:\xampp\htdocs\CODEPHP\resources\views/layouts/master.blade.php ENDPATH**/ ?>