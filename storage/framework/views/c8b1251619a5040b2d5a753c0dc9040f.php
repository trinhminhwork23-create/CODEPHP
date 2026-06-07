<!-- SIDEBAR -->
<aside id="sidebar" class="sidebar">
    <div class="logo-area">
        <a href="<?php echo e(url('/')); ?>" class="d-inline-flex"><img src="<?php echo e(asset('admin/assets/images/logo-icon.svg')); ?>" alt="" width="24">
            <span class="logo-text ms-2"> <img src="<?php echo e(asset('admin/assets/images/logo.svg')); ?>" alt=""></span>
        </a>
    </div>
    <ul class="nav flex-column">
        <li class="px-4 py-2"><small class="nav-text">Main</small></li>
        <li><a class="nav-link active" href="<?php echo e(url('/admin')); ?>"><i class="ti ti-home"></i><span
                    class="nav-text">Dashboard</span></a></li>
        <li><a class="nav-link" href="<?php echo e(url('/admin/rooms')); ?>"><i class="ti ti-box-seam"></i><span
                    class="nav-text">Inventory</span></a></li>
        <li><a class="nav-link" href="<?php echo e(url('/admin/rooms/create')); ?>"><i class="ti ti-plus"></i><span class="nav-text">Add
                    Product</span></a></li>
        <li><a class="nav-link" href="#"><i class="ti ti-receipt"></i><span class="nav-text">Reports</span></a>
        </li>
        <li><a class="nav-link" href="#"><i class="ti ti-alert-circle"></i><span class="nav-text">404 Error</span></a>
        </li>
        <li><a class="nav-link" href="#"><i class="ti ti-file-text"></i><span class="nav-text">Docs</span></a></li>

        <li class="px-4 pt-4 pb-2"><small class="nav-text">Account</small></li>
        <li><a class="nav-link" href="<?php echo e(url('/login')); ?>"><i class="ti ti-logout"></i><span class="nav-text">Log in</span></a>
        </li>
        <li><a class="nav-link" href="<?php echo e(url('/register')); ?>"><i class="ti ti-user-plus"></i><span class="nav-text">Sign
                    up</span></a></li>
    </ul>
</aside>
<?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/admin/layouts/admin_sidebar.blade.php ENDPATH**/ ?>