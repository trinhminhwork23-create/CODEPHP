@extends('admin.layouts.admin_master')

@section('admin_content')

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
                  <th>STT</th>
                  <th>Tên loại phòng</th>
                  <th>Mô tả</th>
                  <th>Ngày tạo</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($categories ?? [] as $index => $category)
                <tr class="align-middle">
                  <td>{{ $index + 1 }}</td>
                  <td class="fw-semibold">{{ $category->name }}</td>
                  <td>{{ Str::limit($category->description, 80) }}</td>
                  <td>{{ $category->created_at->format('d/m/Y') }}</td>
                  <td>
                    <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}"><i class="ti ti-edit"></i></button>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa loại phòng này?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link link-danger p-0"><i class="ti ti-trash ms-2"></i></button>
                    </form>
                  </td>
                </tr>

                {{-- Modal Sửa loại phòng --}}
                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryLabel{{ $category->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title" id="editCategoryLabel{{ $category->id }}">Sửa loại phòng</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="editName{{ $category->id }}" class="form-label">Tên loại phòng</label>
                            <input type="text" class="form-control" id="editName{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="editDesc{{ $category->id }}" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="editDesc{{ $category->id }}" name="description" rows="3">{{ $category->description }}</textarea>
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
                @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">Chưa có loại phòng nào</td>
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

    {{-- Modal Thêm loại phòng --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="addCategoryLabel">Thêm loại phòng mới</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="categoryName" class="form-label">Tên loại phòng</label>
                <input type="text" class="form-control" id="categoryName" name="name" placeholder="VD: Phòng Deluxe" required>
              </div>
              <div class="mb-3">
                <label for="categoryDesc" class="form-label">Mô tả</label>
                <textarea class="form-control" id="categoryDesc" name="description" rows="3" placeholder="Mô tả ngắn gọn về loại phòng"></textarea>
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

@endsection
