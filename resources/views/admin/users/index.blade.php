@extends('admin.layouts.admin_master')

@section('admin_content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="mb-4">
            <h1 class="fs-3 mb-1">Quản lý tài khoản</h1>
            <p class="mb-0">Danh sách tất cả người dùng đã đăng ký trên hệ thống</p>
          </div>
        </div>
      </div>

      {{-- Thông báo --}}
      @if(session('success'))
      <div class="row">
        <div class="col-12">
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
          </div>
        </div>
      </div>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="card table-responsive">
            <table class="table mb-0 text-nowrap table-hover">
              <thead class="table-light border-light">
                <tr>
                  <th>Họ tên</th>
                  <th>Email</th>
                  <th>Vai trò</th>
                  <th>Ngày tạo</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users ?? [] as $index => $user)
                <tr class="align-middle">
                  <td class="fw-semibold">{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if($user->role === 'admin')
                      <span class="badge bg-danger-subtle text-danger">Quản trị viên</span>
                    @elseif($user->role === 'staff')
                      <span class="badge bg-info-subtle text-info">Nhân viên</span>
                    @else
                      <span class="badge bg-primary-subtle text-primary">Khách hàng</span>
                    @endif
                  </td>
                  <td>{{ $user->created_at->format('d/m/Y') }}</td>
                  <td>
                    @if($user->status == 1)
                      <span class="badge bg-success-subtle text-success">Hoạt động</span>
                    @else
                      <span class="badge bg-danger-subtle text-danger">Đã khóa</span>
                    @endif
                  </td>
                  <td>
                    @if($user->role !== 'admin')
                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $user->status == 1 ? 'Khóa tài khoản này?' : 'Mở khóa tài khoản này?' }}')">
                      @csrf
                      @method('PATCH')
                      @if($user->status == 1)
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ti ti-lock me-1"></i>Khóa tài khoản</button>
                      @else
                        <button type="submit" class="btn btn-sm btn-outline-success"><i class="ti ti-lock-open me-1"></i>Mở khóa tài khoản</button>
                      @endif
                    </form>
                    @else
                    <span class="text-muted small">—</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">Chưa có tài khoản nào</td>
                </tr>
                @endforelse
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

@endsection
