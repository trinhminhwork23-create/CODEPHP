@extends('admin.layouts.admin_master')

@section('admin_content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="mb-4">
            <h1 class="fs-3 mb-1">Quản lý đơn đặt phòng</h1>
            <p class="mb-0">Duyệt, theo dõi và quản lý toàn bộ đơn đặt phòng</p>
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
                  <th>Mã đơn</th>
                  <th>Khách hàng</th>
                  <th>Phòng đặt</th>
                  <th>Ngày đến</th>
                  <th>Ngày đi</th>
                  <th>Tổng tiền</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($bookings ?? [] as $booking)
                <tr class="align-middle">
                  <td class="fw-semibold">#{{ $booking->id }}</td>
                  <td>{{ $booking->user->name ?? 'Khách' }}</td>
                  <td>{{ $booking->room->name ?? '—' }}</td>
                  <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}</td>
                  <td class="fw-semibold">{{ number_format($booking->total_money, 0, ',', '.') }}₫</td>
                  <td>
                    @if($booking->status == 0)
                      <span class="badge bg-warning-subtle text-warning">Chờ duyệt</span>
                    @elseif($booking->status == 1)
                      <span class="badge bg-primary-subtle text-primary">Đã duyệt</span>
                    @elseif($booking->status == 2)
                      <span class="badge bg-success-subtle text-success">Đã thanh toán</span>
                    @else
                      <span class="badge bg-danger-subtle text-danger">Đã hủy</span>
                    @endif
                  </td>
                  <td>
                    @if($booking->status == 0)
                      <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Duyệt đơn đặt phòng này?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-success" title="Duyệt đơn"><i class="ti ti-check"></i> Duyệt Booking</button>
                      </form>
                      <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hủy đơn đặt phòng này?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hủy đơn"><i class="ti ti-x"></i> Hủy Booking</button>
                      </form>
                    @elseif($booking->status == 1)
                      <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hủy đơn đặt phòng này?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hủy đơn"><i class="ti ti-x"></i> Hủy Booking</button>
                      </form>
                    @else
                      <span class="text-muted small">—</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9" class="text-center py-4 text-muted">Chưa có đơn đặt phòng nào</td>
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
