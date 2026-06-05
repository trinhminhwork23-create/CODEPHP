@extends('admin.layouts.admin_master')

@section('admin_content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div class="">
              <h1 class="fs-3 mb-1">Thêm phòng mới</h1>
              <p class="mb-0">Nhập thông tin chi tiết phòng nghỉ</p>
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
              <form id="addProductForm" action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="productName" class="form-label">Tên phòng</label>
                    <input type="text" class="form-control" id="productName" name="name" placeholder="Nhập tên phòng" value="{{ old('name') }}" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="productSKU" class="form-label">Mã phòng</label>
                    <input type="text" class="form-control" id="productSKU" name="room_code" placeholder="VD: PH001" value="{{ old('room_code') }}" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="productPrice" class="form-label">Giá / đêm (VNĐ)</label>
                    <input type="number" class="form-control" id="productPrice" name="price" placeholder="0" step="1000" value="{{ old('price') }}" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="productStock" class="form-label">Sức chứa (người)</label>
                    <input type="number" class="form-control" id="productStock" name="capacity" placeholder="2" value="{{ old('capacity') }}" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="roomSize" class="form-label">Diện tích (m²)</label>
                    <input type="number" class="form-control" id="roomSize" name="size" placeholder="35" value="{{ old('size') }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="roomBedType" class="form-label">Loại giường</label>
                    <input type="text" class="form-control" id="roomBedType" name="bed_type" placeholder="VD: King, Twin, Double" value="{{ old('bed_type') }}">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="roomLocation" class="form-label">Vị trí</label>
                    <input type="text" class="form-control" id="roomLocation" name="location" placeholder="VD: Tầng 2, Khu A" value="{{ old('location') }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="productCategory" class="form-label">Loại phòng</label>
                    <select class="form-select" id="productCategory" name="category_id" required>
                      <option value="">Chọn loại phòng</option>
                      @foreach ($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="productImage" class="form-label">Hình ảnh phòng</label>
                  <input type="file" class="form-control" id="productImage" name="image" accept="image/*">
                </div>
                <div class="mb-3">
                  <label for="productDescription" class="form-label">Mô tả chi tiết</label>
                  <textarea class="form-control" id="productDescription" name="description" rows="4"
                    placeholder="Nhập mô tả chi tiết về phòng nghỉ">{{ old('description') }}</textarea>
                </div>
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">Thêm phòng</button>
                  <button type="reset" class="btn btn-secondary">Xóa trắng</button>
                </div>

              </form>
            </div>
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
