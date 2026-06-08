<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <title>Sapa Jade Hill — Bảng điều khiển</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('admin/assets/images/favicon_io/apple-touch-icon.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('admin/assets/images/favicon_io/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('admin/assets/images/favicon_io/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('admin/assets/images/favicon_io/site.webmanifest')); ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- Google Fonts: Inter (Vietnamese subset) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&subset=vietnamese&display=swap" rel="stylesheet">
    <style>
        /* Vietnamese font override – ensure diacritics render correctly in admin panel */
        body, h1, h2, h3, h4, h5, h6, p, a, span, button, input { font-family: 'Inter', sans-serif !important; }
    </style>
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('admin/assets/css/style.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <div id="overlay" class="overlay"></div>

    <?php echo $__env->make('admin.layouts.admin_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('admin.layouts.admin_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- MAIN CONTENT -->
    <main id="content" class="content py-10">
        <?php echo $__env->yieldContent('admin_content'); ?>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- InApp JS -->
    <script src="<?php echo e(asset('admin/assets/js/sidebar.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/assets/js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/assets/js/main.js')); ?>" type="module"></script>
    <script src="<?php echo e(asset('admin/assets/js/notifications-frontend.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html>
<?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/admin/layouts/admin_master.blade.php ENDPATH**/ ?>