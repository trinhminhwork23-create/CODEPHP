

<?php $__env->startSection('admin_content'); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="mb-4">
            <h1 class="fs-3 mb-1">Quản lý tài khoản</h1>
            <p class="mb-0">Danh sách tất cả người dùng đã đăng ký trên hệ thống</p>
          </div>
        </div>
      </div>

      

      <div class="row">
        <div class="col-12">
          <div class="card table-responsive">
            <table class="table mb-0 text-nowrap table-hover">
              <thead class="table-light border-light">
                <tr>
                  <th>Họ tên</th>
                  <th>Email</th>
                  <th>Số điện thoại</th>
                  <th>Vai trò</th>
                  <th>Ngày tạo</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="align-middle">
                  <td class="fw-semibold"><?php echo e($user->name); ?></td>
                  <td><?php echo e($user->email); ?></td>
                  <td><?php echo e($user->phone ?? 'Chưa cập nhật'); ?></td>
                  <td>
                    <?php if($user->role === 'admin'): ?>
                      <span class="badge bg-danger-subtle text-danger">Quản trị viên</span>
                    <?php elseif($user->role === 'staff'): ?>
                      <span class="badge bg-info-subtle text-info">Nhân viên</span>
                    <?php else: ?>
                      <span class="badge bg-primary-subtle text-primary">Khách hàng</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                  <td>
                    <?php if($user->status == 1): ?>
                      <span class="badge bg-success-subtle text-success">Hoạt động</span>
                    <?php else: ?>
                      <span class="badge bg-danger-subtle text-danger">Đã khóa</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($user->role !== 'admin'): ?>
                    <form id="toggle-form-<?php echo e($user->id); ?>" action="<?php echo e(route('admin.users.toggleStatus', $user->id)); ?>" method="POST" class="d-inline">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('PATCH'); ?>
                      <?php if($user->status == 1): ?>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-toggle-status"
                            data-form-id="toggle-form-<?php echo e($user->id); ?>"
                            data-name="<?php echo e($user->name); ?>"
                            data-action="lock">
                          <i class="ti ti-lock me-1"></i>Khóa tài khoản
                        </button>
                      <?php else: ?>
                        <button type="button" class="btn btn-sm btn-outline-success btn-toggle-status"
                            data-form-id="toggle-form-<?php echo e($user->id); ?>"
                            data-name="<?php echo e($user->name); ?>"
                            data-action="unlock">
                          <i class="ti ti-lock-open me-1"></i>Mở khóa tài khoản
                        </button>
                      <?php endif; ?>
                    </form>
                    <?php else: ?>
                    <span class="text-muted small">—</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">Chưa có tài khoản nào</td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <footer class="text-center py-2 mt-6 text-secondary">
            <p class="mb-0">Bản quyền © 2026 Sapa Jade Hill Homestay. Phát triển bởi <a href="#" class="text-primary">SapaJadeHill Team</a></p>
          </footer>
        </div>
      </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // ── Xử lý nút Khóa / Mở khóa bằng SweetAlert2 ─────────────────────────
    document.querySelectorAll('.btn-toggle-status').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const formId = this.dataset.formId;
            const name   = this.dataset.name;
            const action = this.dataset.action;

            const isLock = action === 'lock';

            Swal.fire({
                title: isLock ? 'Khóa tài khoản?' : 'Mở khóa tài khoản?',
                text: isLock
                    ? 'Tài khoản "' + name + '" sẽ bị khóa và không thể đăng nhập.'
                    : 'Tài khoản "' + name + '" sẽ được mở khóa và có thể đăng nhập lại.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: isLock ? '#e3342f' : '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: isLock ? 'Khóa' : 'Mở khóa',
                cancelButtonText: 'Hủy',
            }).then(function (result) {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });

    // ── Hiển thị Session flash message bằng SweetAlert2 ──────────────────────
    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '<?php echo e(session('success')); ?>',
            timer: 2500,
            showConfirmButton: false,
        });
    <?php endif; ?>

    <?php if(session('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '<?php echo e(session('error')); ?>',
        });
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.admin_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/admin/users/index.blade.php ENDPATH**/ ?>