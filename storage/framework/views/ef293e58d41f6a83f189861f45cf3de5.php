

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
                    <?php if($user->is_locked): ?>
                      <span class="badge bg-danger-subtle text-danger"><i class="ti ti-lock"></i> Đã khóa</span>
                    <?php else: ?>
                      <span class="badge bg-success-subtle text-success"><i class="ti ti-lock-open"></i> Hoạt động</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($user->role !== 'admin'): ?>
                      <?php if(!$user->is_locked): ?>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#lockModal<?php echo e($user->id); ?>"
                            data-name="<?php echo e($user->name); ?>"
                            data-action="lock">
                          <i class="ti ti-lock me-1"></i>Khóa tài khoản
                        </button>
                      <?php else: ?>
                        <button type="button" class="btn btn-sm btn-outline-success"
                            data-bs-toggle="modal"
                            data-bs-target="#lockModal<?php echo e($user->id); ?>"
                            data-name="<?php echo e($user->name); ?>"
                            data-action="unlock">
                          <i class="ti ti-lock-open me-1"></i>Mở khóa tài khoản
                        </button>
                      <?php endif; ?>
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

      
      <?php $__currentLoopData = $users ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if($user->role !== 'admin'): ?>
      <div class="modal fade" id="lockModal<?php echo e($user->id); ?>" tabindex="-1" aria-labelledby="lockModalLabel<?php echo e($user->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form action="<?php echo e(route('admin.users.toggleStatus', $user->id)); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PATCH'); ?>
              <div class="modal-header <?php echo e($user->is_locked ? 'bg-success' : 'bg-danger'); ?> text-white">
                <h5 class="modal-title" id="lockModalLabel<?php echo e($user->id); ?>">
                  <i class="ti <?php echo e($user->is_locked ? 'ti-lock-open' : 'ti-lock'); ?> me-2"></i><?php echo e($user->is_locked ? 'Mở khóa' : 'Khóa'); ?> tài khoản
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
              </div>
              <div class="modal-body">
                <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                  <i class="ti ti-info-circle me-2 fs-5"></i>
                  <div>
                    <strong>Yêu cầu bắt buộc:</strong> Vui lòng nhập lý do <?php echo e($user->is_locked ? 'mở khóa' : 'khóa'); ?> tài khoản để ghi nhận vào hệ thống audit.
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold">Tài khoản</label>
                  <input type="text" class="form-control-plaintext fw-semibold" readonly value="<?php echo e($user->name); ?> (<?php echo e($user->email); ?>)">
                </div>
                <div class="mb-3">
                  <label for="lock_reason<?php echo e($user->id); ?>" class="form-label fw-semibold">Lý do <?php echo e($user->is_locked ? 'mở khóa' : 'khóa'); ?> <span class="text-danger">*</span></label>
                  <textarea 
                    class="form-control" 
                    id="lock_reason<?php echo e($user->id); ?>" 
                    name="lock_reason" 
                    rows="4" 
                    placeholder="Nhập lý do <?php echo e($user->is_locked ? 'mở khóa' : 'khóa'); ?> tài khoản..." 
                    required 
                    minlength="10" 
                    maxlength="1000"
                  ></textarea>
                  <div class="form-text">Tối thiểu 10 ký tự, tối đa 1000 ký tự</div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="ti ti-x me-1"></i>Hủy bỏ
                </button>
                <button type="submit" class="btn <?php echo e($user->is_locked ? 'btn-success' : 'btn-danger'); ?>">
                  <i class="ti <?php echo e($user->is_locked ? 'ti-lock-open' : 'ti-lock'); ?> me-1"></i>Xác nhận <?php echo e($user->is_locked ? 'mở khóa' : 'khóa'); ?>

                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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