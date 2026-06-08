

<?php $__env->startSection('admin_content'); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="mb-4">
            <h1 class="fs-3 mb-1">Quản lý đánh giá</h1>
            <p class="mb-0">Xem và kiểm duyệt đánh giá từ khách hàng</p>
          </div>
        </div>
      </div>

      
      <?php if(session('success')): ?>
      <div class="row">
        <div class="col-12">
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-12">
          <div class="card table-responsive">
            <table class="table mb-0 text-nowrap table-hover">
              <thead class="table-light border-light">
                <tr>
                  <th>Người bình luận</th>
                  <th>Phòng</th>
                  <th>Số sao</th>
                  <th>Nội dung bình luận</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reviews ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="align-middle">
                  <td class="fw-semibold"><?php echo e($review->user->name ?? 'Khách'); ?></td>
                  <td><?php echo e($review->room->name ?? '—'); ?></td>
                  <td>
                    <?php for($i = 1; $i <= 5; $i++): ?>
                      <i class="ti ti-star<?php echo e($i <= $review->rating ? '-filled text-warning' : ' text-muted'); ?>"></i>
                    <?php endfor; ?>
                  </td>
                  <td><?php echo e(Str::limit($review->comment, 50)); ?></td>
                  <td>
                    <?php if($review->status == 1): ?>
                      <span class="badge bg-success-subtle text-success">Hiển thị</span>
                    <?php else: ?>
                      <span class="badge bg-secondary-subtle text-secondary">Đã ẩn</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <form action="<?php echo e(route('admin.reviews.toggleVisibility', $review->id)); ?>" method="POST" class="d-inline">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('PATCH'); ?>
                      <?php if($review->status == 1): ?>
                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Ẩn bình luận"><i class="ti ti-eye-off"></i> Ẩn</button>
                      <?php else: ?>
                        <button type="submit" class="btn btn-sm btn-outline-success" title="Hiện bình luận"><i class="ti ti-eye"></i> Hiện</button>
                      <?php endif; ?>
                    </form>
                    <form action="<?php echo e(route('admin.reviews.destroy', $review->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xóa đánh giá này vĩnh viễn?')">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa đánh giá"><i class="ti ti-trash"></i></button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Chưa có đánh giá nào</td>
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

<?php echo $__env->make('admin.layouts.admin_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>