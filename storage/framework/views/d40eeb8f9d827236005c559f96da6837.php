<?php $__env->startSection('admin_content'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h1 class="fs-3 mb-1">Tất cả thông báo</h1>
          <p class="mb-0">Theo dõi các hoạt động và sự kiện trong hệ thống</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="list-group list-group-flush">
          <?php $__empty_1 = true; $__currentLoopData = $notifications ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="list-group-item list-group-item-action">
            <div class="d-flex gap-3">
              <div class="flex-shrink-0">
                <?php if($notification->action === 'Create'): ?>
                  <div class="avatar avatar-md rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center">
                    <i class="ti ti-plus fs-4"></i>
                  </div>
                <?php elseif($notification->action === 'Update'): ?>
                  <div class="avatar avatar-md rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center">
                    <i class="ti ti-edit fs-4"></i>
                  </div>
                <?php elseif($notification->action === 'Delete'): ?>
                  <div class="avatar avatar-md rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center">
                    <i class="ti ti-trash fs-4"></i>
                  </div>
                <?php else: ?>
                  <div class="avatar avatar-md rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center">
                    <i class="ti ti-bell fs-4"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h5 class="mb-1 fs-6">
                      <?php if($notification->action === 'Create'): ?>
                        <span class="badge bg-success-subtle text-success me-2">Tạo mới</span>
                      <?php elseif($notification->action === 'Update'): ?>
                        <span class="badge bg-warning-subtle text-warning me-2">Cập nhật</span>
                      <?php elseif($notification->action === 'Delete'): ?>
                        <span class="badge bg-danger-subtle text-danger me-2">Xóa</span>
                      <?php endif; ?>
                      <?php echo e($notification->target_model); ?>

                    </h5>
                    <p class="mb-1 text-muted"><?php echo e($notification->description); ?></p>
                    <small class="text-secondary">
                      <i class="ti ti-user me-1"></i><?php echo e($notification->user_name); ?>

                      <?php if($notification->role): ?>
                        <span class="badge bg-light text-dark ms-1"><?php echo e($notification->role); ?></span>
                      <?php endif; ?>
                    </small>
                  </div>
                  <small class="text-muted text-nowrap"><?php echo e($notification->created_at->diffForHumans()); ?></small>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="list-group-item text-center py-5">
            <i class="ti ti-bell-off fs-1 text-muted mb-3"></i>
            <p class="text-muted mb-0">Chưa có thông báo nào</p>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <?php if($notifications->hasPages()): ?>
      <div class="mt-4">
        <?php echo e($notifications->links()); ?>

      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>