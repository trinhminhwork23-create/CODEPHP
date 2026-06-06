@extends('admin.layouts.admin_master')

@section('admin_content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="mb-4">
            <h1 class="fs-3 mb-1">Quản lý đánh giá</h1>
            <p class="mb-0">Xem và kiểm duyệt đánh giá từ khách hàng</p>
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
                  <th>Người bình luận</th>
                  <th>Phòng</th>
                  <th>Số sao</th>
                  <th>Nội dung bình luận</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($reviews ?? [] as $index => $review)
                <tr class="align-middle">
                  <td class="fw-semibold">{{ $review->user->name ?? 'Khách' }}</td>
                  <td>{{ $review->room->name ?? '—' }}</td>
                  <td>
                    @for ($i = 1; $i <= 5; $i++)
                      <i class="ti ti-star{{ $i <= $review->rating ? '-filled text-warning' : ' text-muted' }}"></i>
                    @endfor
                  </td>
                  <td>{{ Str::limit($review->comment, 50) }}</td>
                  <td>
                    @if($review->status == 1)
                      <span class="badge bg-success-subtle text-success">Hiển thị</span>
                    @else
                      <span class="badge bg-secondary-subtle text-secondary">Đã ẩn</span>
                    @endif
                  </td>
                  <td>
                    <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('PATCH')
                      @if($review->status == 1)
                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Ẩn bình luận"><i class="ti ti-eye-off"></i> Ẩn</button>
                      @else
                        <button type="submit" class="btn btn-sm btn-outline-success" title="Hiện bình luận"><i class="ti ti-eye"></i> Hiện</button>
                      @endif
                    </form>
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa đánh giá này vĩnh viễn?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa đánh giá"><i class="ti ti-trash"></i></button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Chưa có đánh giá nào</td>
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
