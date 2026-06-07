

<?php $__env->startSection('admin_content'); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
              <h1 class="fs-3 mb-1">Chỉnh sửa phòng</h1>
              <p class="mb-0">Cập nhật thông tin phòng: <strong><?php echo e($room->name); ?></strong></p>
            </div>
            <div>
              <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-primary">Danh sách phòng</a>
            </div>
          </div>
        </div>
      </div>

      
      <?php if($errors->any()): ?>
      <div class="row">
        <div class="col-12">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body p-4">
              <form action="<?php echo e(route('admin.rooms.update', $room->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Tên phòng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="<?php echo e(old('name', $room->name)); ?>" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Mã phòng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="room_code" value="<?php echo e(old('room_code', $room->room_code)); ?>" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Giá / đêm (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="price" value="<?php echo e(old('price', $room->price)); ?>" step="1000" min="1" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Sức chứa (người) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="capacity" value="<?php echo e(old('capacity', $room->capacity)); ?>" min="1" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Diện tích (m²)</label>
                    <input type="number" class="form-control" name="size" value="<?php echo e(old('size', $room->size)); ?>" min="1">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Loại giường</label>
                    <input type="text" class="form-control" name="bed_type" value="<?php echo e(old('bed_type', $room->bed_type)); ?>" placeholder="VD: King, Twin, Double">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Vị trí</label>
                    <input type="text" class="form-control" name="location" value="<?php echo e(old('location', $room->location)); ?>" placeholder="VD: Tầng 2, Khu A">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Loại phòng <span class="text-danger">*</span></label>
                    <select class="form-select" name="category_id" required>
                      <option value="">Chọn loại phòng</option>
                      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $room->category_id) == $category->id ? 'selected' : ''); ?>>
                          <?php echo e($category->name); ?>

                        </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Hình ảnh phòng</label>
                  <?php if($room->image): ?>
                    <div class="mb-2">
                      <img src="<?php echo e(Storage::url($room->image)); ?>" alt="<?php echo e($room->name); ?>" style="height: 100px; border-radius: 6px; object-fit: cover;">
                    </div>
                  <?php endif; ?>
                  <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/jpg">
                  <small class="text-muted">Để trống nếu không muốn thay đổi ảnh.</small>
                </div>

                <div class="mb-3">
                  <label class="form-label">Mô tả chi tiết</label>
                  <textarea class="form-control" name="description" rows="4"><?php echo e(old('description', $room->description)); ?></textarea>
                </div>

                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">Cập nhật phòng</button>
                  <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-secondary">Hủy</a>
                </div>

              </form>
            </div>
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

<?php echo $__env->make('admin.layouts.admin_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\CODEPHP\resources\views/admin/rooms/edit.blade.php ENDPATH**/ ?>