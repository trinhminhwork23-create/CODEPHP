@extends('admin.layouts.admin_master')

@section('admin_content')

    <div class="container-fluid">
      <div class="row ">
        <div class="col-12">
          <div class="mb-6">
            <h1 class="fs-3 mb-1">Bảng điều khiển tổng quan</h1>
            <p>Tổng quan hoạt động kinh doanh Sapa Jade Hill…</p>
          </div>
        </div>
      </div>
      <div class="row g-3 mb-3">
        <div class="col-lg-3 col-12">

          <div class="card p-4  bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-2">

            <div class="d-flex gap-3 ">
              <div class="icon-shape icon-md bg-primary text-white rounded-2">
                <i class="ti ti-report-analytics fs-4"></i>
              </div>
              <div>
                <h2 class="mb-3 fs-6">Tổng doanh thu</h2>
                <h3 class="fw-bold mb-0">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}₫</h3>
                <p class="text-primary mb-0 small">Tổng thu từ đặt phòng</p>
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-3 col-12">

          <div class="card p-4  bg-success bg-opacity-10 border border-success border-opacity-25 rounded-2">

            <div class="d-flex gap-3 ">
              <div class="icon-shape icon-md bg-success text-white rounded-2">
                <i class="ti ti-calendar-event fs-4"></i>
              </div>
              <div>
                <h2 class="mb-3 fs-6">Đơn đặt phòng thành công</h2>
                <h3 class="fw-bold mb-0">{{ $totalBookings ?? 0 }}</h3>
                <p class="text-success mb-0 small">Tổng lượt đặt phòng</p>
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-3 col-12">

          <div class="card p-4  bg-info bg-opacity-10 border border-info border-opacity-25 rounded-2">

            <div class="d-flex gap-3 ">
              <div class="icon-shape icon-md bg-info text-white rounded-2">
                <i class="ti ti-bed fs-4"></i>
              </div>
              <div>
                <h2 class="mb-3 fs-6">Phòng trống hiện tại</h2>
                <h3 class="fw-bold mb-0">{{ $totalRooms ?? 0 }}</h3>
                <p class="text-info mb-0 small">Phòng đang hoạt động</p>
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-3 col-12">

          <div class="card p-4  bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-2">

            <div class="d-flex gap-3 ">
              <div class="icon-shape icon-md bg-warning text-white rounded-2">
                <i class="ti ti-users fs-4"></i>
              </div>
              <div>
                <h2 class="mb-3 fs-6">Tổng khách hàng</h2>
                <h3 class="fw-bold mb-0">{{ $totalCustomers ?? 0 }}</h3>
                <p class="text-warning mb-0 small">Tài khoản đã đăng ký</p>
              </div>
            </div>
          </div>

        </div>

      </div>
      <div class="row g-3 mb-3">
        <div class="col-lg-4 col-12">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between border-bottom pb-5 mb-3">
                <div>
                  <h3 class="fw-bold h4">{{ number_format($pendingBookings ?? 0) }}</h3>
                  <span>Đơn chờ duyệt</span>
                </div>
                <div>
                  <i class="ti ti-clock fs-1 text-primary"></i>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center small">
                <div class="text-muted">Cần xử lý ngay</div>
                <div><a href="{{ route('admin.bookings.index') }}" class="link-primary text-decoration-underline">Xem</a></div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-4 col-12">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between border-bottom pb-5 mb-3">
                <div>
                  <h3 class="fw-bold h4">{{ number_format($cancelledBookings ?? 0) }}</h3>
                  <span>Đơn đã hủy</span>
                </div>
                <div>
                  <i class="ti ti-x fs-1 text-danger"></i>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center small">
                <div class="text-muted">Tổng đơn bị hủy</div>
                <div><a href="{{ route('admin.bookings.index') }}" class="link-primary text-decoration-underline">Xem</a></div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-4 col-12">
          <div class="card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between border-bottom pb-5 mb-3">
                <div>
                  <h3 class="fw-bold h4">{{ $totalReviews ?? 0 }}</h3>
                  <span>Tổng đánh giá</span>
                </div>
                <div>
                  <i class="ti ti-star fs-1 text-warning"></i>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center small">
                <div class="text-muted">Từ khách hàng</div>
                <div><a href="{{ route('admin.reviews.index') }}" class="link-primary text-decoration-underline">Xem</a></div>
              </div>
            </div>
          </div>

        </div>

      </div>
      <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
              <h3 class="h5 mb-0">Doanh thu theo tháng</h3>
              <div>
                <select class="form-select form-select-sm">
                  <option selected>Năm nay</option>
                  <option>Tháng này</option>
                  <option>Tuần này</option>
                </select>
              </div>
            </div>
            <div class="card-body p-4">
              <div id="salesPurchaseChart"></div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
              <h3 class="h5 mb-0">Thông tin tổng quan</h3>
              <div>
                <select class="form-select form-select-sm">
                  <option selected>6 tháng gần đây</option>
                  <option>Tháng này</option>
                  <option>Tuần này</option>
                </select>
              </div>
            </div>
            <div class="card-body p-4">
              <h3 class="h6">Tổng quan khách hàng</h3>
              <div class="row align-items-center">
                <div class="col-sm-6">
                  <div id="customerChart">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-6 border-end">
                      <div class="text-center ">
                        <h2 class="mb-1">{{ $newCustomers ?? 0 }}</h2>
                        <p class="text-success mb-2">Khách mới</p>
                        <span class="badge bg-success"><i class="ti ti-arrow-up-left me-1"></i>Tháng này</span>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="text-center">
                        <h2 class="mb-1">{{ $returningCustomers ?? 0 }}</h2>
                        <p class="text-warning mb-2">Quay lại</p>
                        <span class="badge bg-success badge-xs d-inline-flex align-items-center"><i
                            class="ti ti-arrow-up-left me-1"></i>Tháng này</span>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row text-center border-top mt-4 pt-4">
                <div class="col-4 border-end">
                  <h3 class="fw-bold mb-2">{{ $totalRooms ?? 0 }}</h3>
                  <small class="text-secondary">Phòng</small>
                </div>
                <div class="col-4 border-end">
                  <h3 class="fw-bold mb-2">{{ $totalCustomers ?? 0 }}</h3>
                  <small class="text-secondary">Khách hàng</small>
                </div>
                <div class="col-4">
                  <h3 class="fw-bold mb-2">{{ $totalBookings ?? 0 }}</h3>
                  <small class="text-secondary">Đơn đặt phòng</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row g-3">

        <!-- CARD 1 — Phòng nổi bật -->
        <div class="col-lg-4">
          <div class="card  h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
              <h4 class="mb-0 h5">Phòng được đặt nhiều nhất</h4>
              <button class="btn btn-sm btn-outline-secondary">
                <i class="ti ti-calendar"></i> Hôm nay
              </button>
            </div>

            <ul class="list-group list-group-flush">
              @forelse ($topRooms ?? [] as $room)
              <!-- item -->
              <li class="list-group-item d-flex align-items-center gap-3">
                <img src="{{ $room->image ? asset('storage/' . $room->image) : asset('admin/assets/images/product-2.png') }}" class="rounded" width="48">
                <div class="flex-grow-1">
                  <p class="mb-1">{{ $room->name }}</p>
                  <div class="d-flex align-items-center gap-2 text-muted">
                    <small class="fw-semibold">{{ number_format($room->price, 0, ',', '.') }}₫ </small>
                    <small>•</small>
                    <small>{{ $room->bookings_count ?? 0 }} lượt đặt</small>
                  </div>
                </div>
                <span class="badge bg-primary-subtle text-primary border border-primary">{{ $room->bookings_count ?? 0 }}</span>
              </li>
              @empty
              <li class="list-group-item text-center text-muted py-4">Chưa có dữ liệu</li>
              @endforelse
            </ul>
          </div>
        </div>

        <!-- CARD 2 — Đánh giá gần đây -->
        <div class="col-lg-4">
          <div class="card  h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
              <div class="d-flex align-items-center">
                <h4 class="mb-0 h5">Đánh giá gần đây</h4>
              </div>
              <a href="{{ route('admin.reviews.index') }}" class="small text-primary text-decoration-underline">Xem tất cả</a>
            </div>

            <ul class="list-group list-group-flush">
              @forelse ($latestReviews ?? [] as $review)
              <li class="list-group-item d-flex align-items-center gap-3">
                <img src="{{ asset('admin/assets/images/avatar/avatar-1.jpg') }}" class="rounded" width="48">
                <div class="flex-grow-1">
                  <p class="mb-1">{{ $review->user->name ?? 'Khách' }}</p>
                  <small>{{ Str::limit($review->comment, 40) }}</small>
                </div>
                <div class="d-flex flex-column gap-0 align-items-center">
                  <span class="fw-semibold text-primary">{{ $review->rating }}<i class="ti ti-star-filled text-warning ms-1"></i></span>
                  <small class="text-muted">{{ $review->room->name ?? '' }}</small>
                </div>
              </li>
              @empty
              <li class="list-group-item text-center text-muted py-4">Chưa có đánh giá</li>
              @endforelse
            </ul>
          </div>
        </div>

        <!-- CARD 3 — Đơn đặt phòng gần đây -->
        <div class="col-lg-4">
          <div class="card  h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
              <h4 class="mb-0 h5">Đơn đặt gần đây</h4>
              <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="ti ti-calendar-event"></i> Xem tất cả
              </a>
            </div>

            <ul class="list-group list-group-flush">
              @forelse ($latestBookings ?? [] as $booking)
              <li class="list-group-item d-flex align-items-center gap-3">
                <img src="{{ asset('admin/assets/images/avatar/avatar-1.jpg') }}" class="rounded" width="48">
                <div class="flex-grow-1">
                  <p class="mb-1">{{ $booking->user->name ?? 'Khách' }}</p>
                  <div class="d-flex align-items-center gap-2 text-muted">
                    <small class="fw-semibold">{{ $booking->room->name ?? '' }} </small>
                    <small>•</small>
                    <small>{{ number_format($booking->total_money, 0, ',', '.') }}₫</small>
                  </div>
                </div>
                @if($booking->status == 0)
                  <span class="badge bg-warning-subtle text-warning">Chờ duyệt</span>
                @elseif($booking->status == 1)
                  <span class="badge bg-primary-subtle text-primary">Đã duyệt</span>
                @elseif($booking->status == 2)
                  <span class="badge bg-success-subtle text-success">Đã thanh toán</span>
                @else
                  <span class="badge bg-danger-subtle text-danger">Đã hủy</span>
                @endif
              </li>
              @empty
              <li class="list-group-item text-center text-muted py-4">Chưa có đơn đặt phòng</li>
              @endforelse
            </ul>
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
