<?php $__env->startSection('admin_content'); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h1 class="fs-3 mb-1">Nhật ký hệ thống</h1>
              <p class="mb-0">Theo dõi mọi hoạt động thay đổi dữ liệu trong hệ thống</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card table-responsive">
            <table class="table mb-0 text-nowrap table-hover">
              <thead class="table-light border-light">
                <tr>
                  <th>Thời gian</th>
                  <th>Người thực hiện</th>
                  <th>Vai trò</th>
                  <th>Hành động</th>
                  <th>Đối tượng</th>
                  <th>Mô tả</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="align-middle">
                  <td><?php echo e($log->created_at->format('d/m/Y H:i:s')); ?></td>
                  <td><?php echo e($log->user_name); ?></td>
                  <td>
                    <?php if($log->role === 'Admin'): ?>
                      <span class="badge bg-danger-subtle text-danger">Admin</span>
                    <?php elseif($log->role === 'Staff'): ?>
                      <span class="badge bg-info-subtle text-info">Staff</span>
                    <?php else: ?>
                      <span class="badge bg-success-subtle text-success">Guest</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($log->action === 'Create'): ?>
                      <span class="badge bg-success">Tạo mới</span>
                    <?php elseif($log->action === 'Update'): ?>
                      <span class="badge bg-warning">Cập nhật</span>
                    <?php else: ?>
                      <span class="badge bg-danger">Xóa</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="text-muted"><?php echo e($log->target_model); ?> #<?php echo e($log->target_id); ?></span>
                  </td>
                  <td><?php echo e($log->description); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Chưa có hoạt động nào được ghi nhận</td>
                </tr>
                <?php endif; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td class="border-bottom-0">Hiển thị <?php echo e($logs->firstItem() ?? 0); ?>-<?php echo e($logs->lastItem() ?? 0); ?> / tổng <?php echo e($logs->total()); ?> bản ghi</td>
                  <td colspan="5" class="border-bottom-0"><?php echo e($logs->links()); ?></td>
                </tr>
              </tfoot>
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

<?php echo $__env->make('admin.layouts.admin_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/admin/logs/index.blade.php ENDPATH**/ ?>