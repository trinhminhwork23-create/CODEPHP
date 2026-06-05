<?php $__env->startSection('admin_content'); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h1 class="fs-3 mb-1">Loại phòng</h1>
              <p class="mb-0">Quản lý danh mục phòng nghỉ tại Sapa Jade Hill</p>
            </div>
            <div>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Thêm loại phòng</button>
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
                  <th>STT</th>
                  <th>Ảnh</th>
                  <th>Tên loại phòng</th>
                  <th>Giá</th>
                  <th>Sức chứa</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="align-middle">
                  <td><?php echo e($index + 1); ?></td>
                  <td>
                    <?php if($category->image): ?>
                      <img src="<?php echo e(Storage::url($category->image)); ?>" alt="<?php echo e($category->name); ?>" style="width: 60px; height: 45px; object-fit: cover; border-radius: 4px;">
                    <?php else: ?>
                      <span class="text-muted small">—</span>
                    <?php endif; ?>
                  </td>
                  <td class="fw-semibold"><?php echo e($category->name); ?></td>
                  <td><?php echo e(number_format($category->price, 0, ',', '.')); ?> đ</td>
                  <td><?php echo e($category->capacity); ?> người</td>
                  <td>
                    <?php if($category->status): ?>
                      <span class="badge bg-success-subtle text-success">Hoạt động</span>
                    <?php else: ?>
                      <span class="badge bg-danger-subtle text-danger">Ẩn</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo e($category->created_at->format('d/m/Y')); ?></td>
                  <td>
                    <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?php echo e($category->id); ?>">
                      <i class="ti ti-edit"></i>
                    </button>
                    <form id="delete-form-<?php echo e($category->id); ?>" action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" class="d-inline">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="button" class="btn btn-link link-danger p-0 btn-delete" data-form-id="delete-form-<?php echo e($category->id); ?>" data-name="<?php echo e($category->name); ?>">
                        <i class="ti ti-trash ms-2"></i>
                      </button>
                    </form>
                  </td>
                </tr>

                
                <div class="modal fade" id="editCategoryModal<?php echo e($category->id); ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="<?php echo e(route('admin.categories.update', $category->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="modal-header">
                          <h5 class="modal-title">Sửa loại phòng</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Tên loại phòng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="<?php echo e($category->name); ?>" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description" rows="3"><?php echo e($category->description); ?></textarea>
                          </div>
                          <div class="row">
                            <div class="col-6 mb-3">
                              <label class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                              <input type="number" class="form-control" name="price" value="<?php echo e($category->price); ?>" min="1" required>
                            </div>
                            <div class="col-6 mb-3">
                              <label class="form-label">Sức chứa <span class="text-danger">*</span></label>
                              <input type="number" class="form-control" name="capacity" value="<?php echo e($category->capacity); ?>" min="1" required>
                            </div>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Ảnh đại diện</label>
                            <?php if($category->image): ?>
                              <div class="mb-2">
                                <img src="<?php echo e(Storage::url($category->image)); ?>" style="height: 80px; border-radius: 4px;">
                              </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/jpg">
                            <small class="text-muted">Để trống nếu không muốn thay đổi ảnh.</small>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="status">
                              <option value="1" <?php echo e($category->status ? 'selected' : ''); ?>>Hoạt động</option>
                              <option value="0" <?php echo e(!$category->status ? 'selected' : ''); ?>>Ẩn</option>
                            </select>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="8" class="text-center py-4 text-muted">Chưa có loại phòng nào</td>
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

    
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
              <h5 class="modal-title">Thêm loại phòng mới</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Tên loại phòng <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="VD: Phòng Deluxe" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="description" rows="3" placeholder="Mô tả ngắn gọn về loại phòng"></textarea>
              </div>
              <div class="row">
                <div class="col-6 mb-3">
                  <label class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" name="price" placeholder="VD: 1500000" min="1" required>
                </div>
                <div class="col-6 mb-3">
                  <label class="form-label">Sức chứa <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" name="capacity" placeholder="VD: 2" min="1" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/jpg" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select class="form-select" name="status">
                  <option value="1">Hoạt động</option>
                  <option value="0">Ẩn</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // ── Xử lý nút xóa bằng SweetAlert2 ──────────────────────────────────────
    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const formId = this.dataset.formId;
            const name   = this.dataset.name;

            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: '"' + name + '" sẽ bị xóa vĩnh viễn và không thể khôi phục!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor:  '#6c757d',
                confirmButtonText: 'Xóa',
                cancelButtonText:  'Hủy',
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

<?php echo $__env->make('admin.layouts.admin_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Php\htdocs\CODEPHP\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>