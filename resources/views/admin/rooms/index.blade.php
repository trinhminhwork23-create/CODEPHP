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

      {{-- Thông báo thành công --}}
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
          <div>
            <div class="d-flex gap-2 mb-3 flex-wrap justify-content-between">
              <input type="text" class="form-control" placeholder="Tìm kiếm phòng..." style="max-width: 250px;">
              <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary">
                  <i class="ti ti-filter"></i> Lọc
                </button>
                <button class="btn btn-outline-secondary">
                  <i class="ti ti-file-excel"></i> Excel
                </button>
                <button class="btn btn-outline-secondary">
                  <i class="ti ti-file-pdf"></i> PDF
                </button>
              </div>
            </div>
          </div>
          <div class="card table-responsive ">
            <table class="table mb-0 text-nowrap table-hover">
              <thead class="table-light border-light">
                <tr>
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
                  <td class="fw-semibold">{{ $room->room_code }}</td>
                  <td><a href="{{ route('admin.rooms.edit', $room->id) }}"><img src="{{ $room->image ? asset('storage/' . $room->image) : asset('admin/assets/images/product-1.png') }}" alt="{{ $room->name }}" class="avatar avatar-md rounded" /><span class="ms-3">{{ $room->name }}</span></a></td>
                  <td>{{ $room->category->name ?? '—' }}</td>
                  <td>{{ $room->location ?? '—' }}</td>
                  <td>{{ number_format($room->price, 0, ',', '.') }}₫</td>
                  <td>{{ $room->capacity }} người</td>
                  <td>{{ $room->size ? $room->size . ' m²' : '—' }}</td>
                  <td class="">
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class=""><i class="ti ti-edit "></i></a>
                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link link-danger p-0"><i class="ti ti-trash ms-2"></i></button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="text-center py-4 text-muted">Chưa có phòng nào được thêm</td>
                </tr>
                @endforelse
              </tbody>
              <tfoot class="">
                <tr>
                  <td class="border-bottom-0">Hiển thị {{ ($rooms ?? collect())->count() }} phòng</td>
                  <td colspan="9" class="border-bottom-0">
                    @if(method_exists($rooms ?? collect(), 'links'))
                    {{ $rooms->links() }}
                    @endif
                  </td>
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
