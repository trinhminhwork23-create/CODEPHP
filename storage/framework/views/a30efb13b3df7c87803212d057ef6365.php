

<?php $__env->startSection('admin_content'); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="">
              <h1 class="fs-3 mb-1">Quản lý phòng</h1>
              <p class="mb-0">Danh sách toàn bộ phòng nghỉ tại Sapa Jade Hill</p>
            </div>
            <div>
              <a href="<?php echo e(route('admin.rooms.create')); ?>" class="btn btn-primary">Thêm phòng mới</a>
            </div>
          </div>
        </div>
      </div>

      

      <div class="row">
        <div class="col-12">
          <div>
            <form method="GET" action="<?php echo e(route('admin.rooms.index')); ?>" class="d-flex gap-2 mb-3 flex-wrap align-items-center justify-content-between">
              <div class="d-flex gap-2 flex-wrap">
                <input type="text" class="form-control" name="search" placeholder="Tìm tên hoặc mã phòng..." value="<?php echo e(request('search')); ?>" style="max-width: 220px;">
                <select class="form-select" name="category_id" style="max-width: 200px;">
                  <option value="">Tất cả loại phòng</option>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="btn btn-primary">
                  <i class="ti ti-search me-1"></i> Lọc
                </button>
                <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-outline-secondary">
                  <i class="ti ti-refresh me-1"></i> Reset
                </a>
              </div>
            </form>
          </div>
          <div class="card table-responsive ">
            <table class="table mb-0 text-nowrap table-hover">
              <thead class="table-light border-light">
                <tr>
                  <th>Hình ảnh</th>
                  <th>Mã phòng</th>
                  <th>Tên phòng</th>
                  <th>Loại phòng</th>
                  <th>Phân khu</th>
                  <th>Giá/Đêm</th>
                  <th>Sức chứa</th>
                  <th>Diện tích</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $rooms ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="align-middle">
                  <td>
                    <?php if($room->image && file_exists(public_path('storage/' . $room->image))): ?>
                      <img src="<?php echo e(asset('storage/' . $room->image)); ?>" alt="<?php echo e($room->name); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                    <?php else: ?>
                      <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=120&q=60" alt="<?php echo e($room->name); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover; opacity:.6;">
                    <?php endif; ?>
                  </td>
                  <td class="fw-semibold"><?php echo e($room->room_code); ?></td>
                  <td>
                    <a href="<?php echo e(route('admin.rooms.edit', $room->id)); ?>" class="text-dark text-decoration-none fw-semibold">
                      <?php echo e($room->name); ?>

                    </a>
                  </td>
                  <td><?php echo e($room->category->name ?? '—'); ?></td>
                  <td><?php echo e($room->location ?? '—'); ?></td>
                  <td><?php echo e(number_format($room->price, 0, ',', '.')); ?>₫</td>
                  <td><?php echo e($room->capacity); ?> người</td>
                  <td><?php echo e($room->size ? $room->size . ' m²' : '—'); ?></td>
                  <td class="">
                    <a href="<?php echo e(route('admin.rooms.edit', $room->id)); ?>" class=""><i class="ti ti-edit "></i></a>
                    <form action="<?php echo e(route('admin.rooms.destroy', $room->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng <?php echo e($room->name); ?>?')">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="btn btn-link link-danger p-0" title="Xóa phòng">
                        <i class="ti ti-trash ms-2"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="9" class="text-center py-4 text-muted">Chưa có phòng nào được thêm</td>
                </tr>
                <?php endif; ?>
              </tbody>
              <tfoot class="">
                <tr>
                  <td class="border-bottom-0">Hiển thị <?php echo e($rooms->firstItem() ?? 0); ?>-<?php echo e($rooms->lastItem() ?? 0); ?> / tổng <?php echo e($rooms->total()); ?> phòng</td>
                  <td colspan="9" class="border-bottom-0"><?php echo e($rooms->links()); ?></td>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>

      </div>
      <div class="row">
        <div class="col-12">
          <footer class="text-center py-2 mt-6 text-secondary ">
            <p class="mb-0">Bản quyền © 2026 Sapa Jade Hill Homestay. Phát triển bởi <a href="#" class="text-primary">SapaJadeHill Team</a></p>
          </footer>
        </div>
      </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // ── Xử lý nút xóa phòng bằng SweetAlert2 ───────────────────────────────
    document.querySelectorAll('.btn-delete-room').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const formId = this.dataset.formId;
            const name   = this.dataset.name;

            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: 'Phòng "' + name + '" sẽ bị xóa vĩnh viễn và không thể khôi phục!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Xóa',
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

<?php echo $__env->make('admin.layouts.admin_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/admin/rooms/index.blade.php ENDPATH**/ ?>