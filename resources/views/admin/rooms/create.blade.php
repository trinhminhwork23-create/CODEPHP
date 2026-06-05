@extends('admin.layouts.admin_master')

@section('admin_content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
              <h1 class="fs-3 mb-1">Thêm phòng mới</h1>
              <p class="mb-0">Nhập thông tin chi tiết phòng nghỉ</p>
            </div>
            <div>
              <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary">Danh sách phòng</a>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body p-4">
              <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Tên phòng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nhập tên phòng" value="{{ old('name') }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Mã phòng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('room_code') is-invalid @enderror" name="room_code" placeholder="VD: PH001" value="{{ old('room_code') }}">
                    @error('room_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Giá / đêm (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" placeholder="0" step="1000" value="{{ old('price') }}">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Sức chứa (người) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" name="capacity" placeholder="2" value="{{ old('capacity') }}">
                    @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Diện tích (m²)</label>
                    <input type="number" class="form-control @error('size') is-invalid @enderror" name="size" placeholder="35" value="{{ old('size') }}">
                    @error('size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Loại giường</label>
                    <input type="text" class="form-control @error('bed_type') is-invalid @enderror" name="bed_type" placeholder="VD: King, Twin, Double" value="{{ old('bed_type') }}">
                    @error('bed_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Vị trí</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" placeholder="VD: Tầng 2, Khu A" value="{{ old('location') }}">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Loại phòng <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                      <option value="">Chọn loại phòng</option>
                      @foreach ($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                      @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Hình ảnh phòng</label>
                  <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/jpeg,image/png,image/jpg">
                  @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label">Mô tả chi tiết</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4" placeholder="Nhập mô tả chi tiết về phòng nghỉ">{{ old('description') }}</textarea>
                  @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">Thêm phòng</button>
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
