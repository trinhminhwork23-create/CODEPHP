@extends('admin.layouts.admin_master')

@section('admin_content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="">
              <h1 class="fs-3 mb-1">Quản lý phòng</h1>
              <p class="mb-0">Danh sách toàn bộ phòng nghỉ tại Sapa Jade Hill</p>
            </div>
            <div>
              <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Thêm phòng mới</a>
            </div>
          </div>
        </div>
      </div>

      {{-- Thông báo session được xử lý bằng SweetAlert2 ở script bên dưới --}}

      <div class="row">
        <div class="col-12">
          <div>
            <form method="GET" action="{{ route('admin.rooms.index') }}" class="d-flex gap-2 mb-3 flex-wrap align-items-center justify-content-between">
              <div class="d-flex gap-2 flex-wrap">
                <input type="text" class="form-control" name="search" placeholder="Tìm tên hoặc mã phòng..." value="{{ request('search') }}" style="max-width: 220px;">
                <select class="form-select" name="category_id" style="max-width: 200px;">
                  <option value="">Tất cả loại phòng</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary">
                  <i class="ti ti-search me-1"></i> Lọc
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">
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
                @forelse ($rooms ?? [] as $room)
                <tr class="align-middle">
                  <td>
                    @if($room->image && file_exists(public_path('storage/' . $room->image)))
                      <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                      <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=120&q=60" alt="{{ $room->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover; opacity:.6;">
                    @endif
                  </td>
                  <td class="fw-semibold">{{ $room->room_code }}</td>
                  <td>
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="text-dark text-decoration-none fw-semibold">
                      {{ $room->name }}
                    </a>
                  </td>
                  <td>{{ $room->category->name ?? '—' }}</td>
                  <td>{{ $room->location ?? '—' }}</td>
                  <td>{{ number_format($room->price, 0, ',', '.') }}₫</td>
                  <td>{{ $room->capacity }} người</td>
                  <td>{{ $room->size ? $room->size . ' m²' : '—' }}</td>
                  <td class="">
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class=""><i class="ti ti-edit "></i></a>
                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng {{ $room->name }}?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link link-danger p-0" title="Xóa phòng">
                        <i class="ti ti-trash ms-2"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9" class="text-center py-4 text-muted">Chưa có phòng nào được thêm</td>
                </tr>
                @endforelse
              </tbody>
              <tfoot class="">
                <tr>
                  <td class="border-bottom-0">Hiển thị {{ $rooms->firstItem() ?? 0 }}-{{ $rooms->lastItem() ?? 0 }} / tổng {{ $rooms->total() }} phòng</td>
                  <td colspan="9" class="border-bottom-0">{{ $rooms->links() }}</td>
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

@endsection

@push('scripts')
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
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false,
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ session('error') }}',
        });
    @endif
</script>
@endpush
