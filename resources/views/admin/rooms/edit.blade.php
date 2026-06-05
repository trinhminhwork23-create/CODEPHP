@extends('admin.layouts.admin_master')

@section('admin_content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
              <h1 class="fs-3 mb-1">Chỉnh sửa phòng</h1>
              <p class="mb-0">Cập nhật thông tin phòng: <strong>{{ $room->name }}</strong></p>
            </div>
            <div>
              <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary">Danh sách phòng</a>
            </div>
          </div>
        </div>
      </div>

      {{-- Hiển thị lỗi validation --}}
      @if($errors->any())
      <div class="row">
        <div class="col-12">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
          </div>
        </div>
      </div>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body p-4">
              <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Tên phòng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $room->name) }}" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Mã phòng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="room_code" value="{{ old('room_code', $room->room_code) }}" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Giá / đêm (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="price" value="{{ old('price', $room->price) }}" step="1000" min="1" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Sức chứa (người) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="capacity" value="{{ old('capacity', $room->capacity) }}" min="1" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Diện tích (m²)</label>
                    <input type="number" class="form-control" name="size" value="{{ old('size', $room->size) }}" min="1">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Loại giường</label>
                    <input type="text" class="form-control" name="bed_type" value="{{ old('bed_type', $room->bed_type) }}" placeholder="VD: King, Twin, Double">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Vị trí</label>
                    <input type="text" class="form-control" name="location" value="{{ old('location', $room->location) }}" placeholder="VD: Tầng 2, Khu A">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Loại phòng <span class="text-danger">*</span></label>
                    <select class="form-select" name="category_id" required>
                      <option value="">Chọn loại phòng</option>
                      @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $room->category_id) == $category->id ? 'selected' : '' }}>
                          {{ $category->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Hình ảnh phòng</label>
                  @if($room->image)
                    <div class="mb-2">
                      <img src="{{ Storage::url($room->image) }}" alt="{{ $room->name }}" style="height: 100px; border-radius: 6px; object-fit: cover;">
                    </div>
                  @endif
                  <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/jpg">
                  <small class="text-muted">Để trống nếu không muốn thay đổi ảnh.</small>
                </div>

                <div class="mb-3">
                  <label class="form-label">Mô tả chi tiết</label>
                  <textarea class="form-control" name="description" rows="4">{{ old('description', $room->description) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">Cập nhật phòng</button>
                  <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Hủy</a>
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

@endsection
