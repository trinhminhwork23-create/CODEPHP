

<?php $__env->startSection('admin_content'); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="mb-4">
            <h1 class="fs-3 mb-1">Quản lý đơn đặt phòng</h1>
            <p class="mb-0">Duyệt, theo dõi và quản lý toàn bộ đơn đặt phòng</p>
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

      
      <?php if($errors->any() || session('error')): ?>
      <div class="row">
        <div class="col-12">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0" style="padding-left: 20px;">
                <?php if(session('error')): ?>
                    <li><?php echo e(session('error')); ?></li>
                <?php endif; ?>
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
          <div class="card table-responsive">
            <table class="table mb-0 text-nowrap table-hover">
              <thead class="table-light border-light">
                <tr>
                  <th>Mã đơn</th>
                  <th>Khách hàng</th>
                  <th>Phòng đặt</th>
                  <th>Ngày đến</th>
                  <th>Ngày đi</th>
                  <th>Tổng tiền</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $bookings ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="align-middle">
                  <td class="fw-semibold">#<?php echo e($booking->id); ?></td>
                  <td><?php echo e($booking->user->name ?? 'Khách'); ?></td>
                  <td><?php echo e($booking->room->name ?? '—'); ?></td>
                  <td><?php echo e(\Carbon\Carbon::parse($booking->check_in)->format('d/m/Y')); ?></td>
                  <td><?php echo e(\Carbon\Carbon::parse($booking->check_out)->format('d/m/Y')); ?></td>
                  <td class="fw-semibold"><?php echo e(number_format($booking->total_money, 0, ',', '.')); ?>₫</td>
                  
                  
                  <td>
                    <?php if($booking->status == \App\Models\Booking::STATUS_PENDING): ?>
                      <span class="badge bg-warning-subtle text-warning">Chờ duyệt</span>
                    <?php elseif($booking->status == \App\Models\Booking::STATUS_APPROVED): ?>
                      <span class="badge bg-primary-subtle text-primary">Đã duyệt</span>
                    <?php elseif($booking->status == \App\Models\Booking::STATUS_PAID): ?>
                      <span class="badge bg-success-subtle text-success">Đã thanh toán</span>
                    <?php else: ?>
                      <span class="badge bg-danger-subtle text-danger">Đã hủy</span>
                    <?php endif; ?>
                  </td>
                  
                  <td>
                    
                    <?php if($booking->status == \App\Models\Booking::STATUS_PENDING): ?>
                      <form action="<?php echo e(route('admin.bookings.approve', $booking->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Duyệt đơn đặt phòng này?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-success" title="Duyệt đơn"><i class="ti ti-check"></i> Duyệt Booking</button>
                      </form>
                    <?php endif; ?>

                    
                    <?php if(in_array($booking->status, [\App\Models\Booking::STATUS_PENDING, \App\Models\Booking::STATUS_APPROVED])): ?>
                      <form action="<?php echo e(route('admin.bookings.cancel', $booking->id)); ?>" method="POST" class="d-inline" onsubmit="return handleForceCancel(event, this)">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="cancel_reason" class="cancel-reason-input">
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hủy đơn"><i class="ti ti-x"></i> Hủy Booking</button>
                      </form>
                    <?php endif; ?>

                    
                    <?php if(in_array($booking->status, [\App\Models\Booking::STATUS_PAID, \App\Models\Booking::STATUS_CANCELLED])): ?>
                      <span class="text-muted small">—</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="8" class="text-center py-4 text-muted">Chưa có đơn đặt phòng nào</td>
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

    
    <script>
      function handleForceCancel(event, form) {
          event.preventDefault(); // Ngăn chặn form submit ngay lập tức
          
          // Bật hộp thoại hỏi lý do
          let reason = prompt("Vui lòng nhập lý do hủy đơn cưỡng chế (Bắt buộc):");
          
          // Nếu Admin bấm "Hủy bỏ" trên hộp thoại
          if (reason === null) {
              return false; 
          }
          
          // Nếu Admin để trống và bấm OK
          if (reason.trim() === "") {
              alert("Thao tác thất bại! Bạn bắt buộc phải nhập lý do để hủy đơn này.");
              return false;
          }
          
          // Gán lý do vào thẻ input ẩn và tiến hành submit gửi lên Backend
          form.querySelector('.cancel-reason-input').value = reason;
          form.submit();
      }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\CODEPHP\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>