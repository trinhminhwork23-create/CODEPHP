@extends('admin.layouts.admin_master')

@section('admin_content')

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
                @forelse ($logs ?? [] as $log)
                <tr class="align-middle">
                  <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                  <td>{{ $log->user_name }}</td>
                  <td>
                    @if($log->role === 'Admin')
                      <span class="badge bg-danger-subtle text-danger">Admin</span>
                    @elseif($log->role === 'Staff')
                      <span class="badge bg-info-subtle text-info">Staff</span>
                    @else
                      <span class="badge bg-success-subtle text-success">Guest</span>
                    @endif
                  </td>
                  <td>
                    @if($log->action === 'Create')
                      <span class="badge bg-success">Tạo mới</span>
                    @elseif($log->action === 'Update')
                      <span class="badge bg-warning">Cập nhật</span>
                    @else
                      <span class="badge bg-danger">Xóa</span>
                    @endif
                  </td>
                  <td>
                    <span class="text-muted">{{ $log->target_model }} #{{ $log->target_id }}</span>
                  </td>
                  <td>{{ $log->description }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Chưa có hoạt động nào được ghi nhận</td>
                </tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <td class="border-bottom-0">Hiển thị {{ $logs->firstItem() ?? 0 }}-{{ $logs->lastItem() ?? 0 }} / tổng {{ $logs->total() }} bản ghi</td>
                  <td colspan="5" class="border-bottom-0">{{ $logs->links() }}</td>
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

@endsection
