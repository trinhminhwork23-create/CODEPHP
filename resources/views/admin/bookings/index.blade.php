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
                      <span class="badge bg-primary-subtle text-primary">Đã đặt cọc 50%</span>
                    @elseif($booking->status == 2)
                      <span class="badge bg-success-subtle text-success">Đã thanh toán</span>
                    @elseif($booking->status == 3)
                      <span class="badge bg-danger-subtle text-danger">Đã hủy</span>
                    @elseif($booking->status == 4)
                      <span class="badge bg-info-subtle text-info">Đã nhận phòng</span>
                    @elseif($booking->status == 5)
                      <span class="badge bg-secondary-subtle text-secondary">Hoàn thành</span>
                    @endif
                  </td>
                  <td>
                    @if($booking->status == 0)
                      <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Duyệt đơn đặt phòng này?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="sapa-admin-btn sapa-admin-btn-approve" title="Duyệt đơn"><i class="ti ti-check"></i> Duyệt Booking</button>
                      </form>
                      <button type="button" class="sapa-admin-btn sapa-admin-btn-cancel" 
                              data-bs-toggle="modal" 
                              data-bs-target="#cancelModal{{ $booking->id }}" 
                              title="Hủy đơn">
                        <i class="ti ti-x"></i> Hủy Booking
                      </button>
                    @elseif($booking->status == 1 || $booking->status == 2)
                      <form action="{{ route('admin.bookings.checkin', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận khách đã nhận phòng?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="sapa-admin-btn sapa-admin-btn-checkin" title="Nhận phòng">
                          <i class="ti ti-door-enter"></i> Xác nhận Nhận phòng
                        </button>
                      </form>
                      <button type="button" class="sapa-admin-btn sapa-admin-btn-cancel" 
                              data-bs-toggle="modal" 
                              data-bs-target="#cancelModal{{ $booking->id }}" 
                              title="Hủy đơn cưỡng chế">
                        <i class="ti ti-x"></i> Hủy đơn cưỡng chế
                      </button>
                    @elseif($booking->status == 4)
                      <form action="{{ route('admin.bookings.checkout', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận khách đã trả phòng?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="sapa-admin-btn sapa-admin-btn-checkout" title="Trả phòng">
                          <i class="ti ti-door-exit"></i> Xác nhận Trả phòng
                        </button>
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

      {{-- Cancel Booking Modal - Loop through all bookings --}}
      @foreach ($bookings ?? [] as $booking)
      <div class="modal fade" id="cancelModal{{ $booking->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $booking->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="cancelModalLabel{{ $booking->id }}">
                  <i class="ti ti-alert-triangle me-2"></i>Hủy đơn cưỡng chế #{{ $booking->id }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
              </div>
              <div class="modal-body">
                <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                  <i class="ti ti-info-circle me-2 fs-5"></i>
                  <div>
                    <strong>Yêu cầu bắt buộc:</strong> Vui lòng nhập lý do hủy đơn để ghi nhận vào hệ thống audit.
                  </div>
                </div>
                <div class="mb-3">
                  <label for="cancel_reason{{ $booking->id }}" class="form-label fw-semibold">Lý do hủy đơn cưỡng chế <span class="text-danger">*</span></label>
                  <textarea 
                    class="form-control" 
                    id="cancel_reason{{ $booking->id }}" 
                    name="cancel_reason" 
                    rows="4" 
                    placeholder="Nhập lý do hủy đơn cưỡng chế..." 
                    required 
                    minlength="10" 
                    maxlength="1000"
                  ></textarea>
                  <div class="form-text">Tối thiểu 10 ký tự, tối đa 1000 ký tự</div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="ti ti-x me-1"></i>Hủy bỏ
                </button>
                <button type="submit" class="btn btn-danger">
                  <i class="ti ti-ban me-1"></i>Xác nhận hủy đơn
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach

      <div class="row">
        <div class="col-12">
          <footer class="text-center py-2 mt-6 text-secondary">
            <p class="mb-0">Copyright © 2026 Bản quyền thuộc về Nhóm lập trình web 11.</p>
          </footer>
        </div>
      </div>
    </div>

@push('styles')
<style>
    .sapa-admin-btn {
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid transparent;
        text-transform: none;
        letter-spacing: normal;
        cursor: pointer;
    }
    .sapa-admin-btn-approve {
        color: #2e7d32;
        background-color: #e8f5e9;
        border-color: #c8e6c9;
    }
    .sapa-admin-btn-approve:hover {
        color: #ffffff;
        background-color: #2e7d32;
        border-color: #2e7d32;
    }
    .sapa-admin-btn-cancel {
        color: #d32f2f;
        background-color: #ffebee;
        border-color: #ffcdd2;
    }
    .sapa-admin-btn-cancel:hover {
        color: #ffffff;
        background-color: #d32f2f;
        border-color: #d32f2f;
    }
    .sapa-admin-btn-checkin {
        color: #ffffff;
        background-color: #dfa974;
        border-color: #dfa974;
    }
    .sapa-admin-btn-checkin:hover {
        background-color: #c99560;
        border-color: #c99560;
    }
    .sapa-admin-btn-checkout {
        color: #ffffff;
        background-color: #0288d1;
        border-color: #0288d1;
    }
    .sapa-admin-btn-checkout:hover {
        background-color: #01579b;
        border-color: #01579b;
    }
    
    /* Audit Modal Styles */
    .modal-content {
        border-radius: 12px;
        border: none;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .modal-header.bg-danger {
        background: linear-gradient(135deg, #d32f2f, #ef5350) !important;
        padding: 20px 24px;
    }
    .modal-body {
        padding: 24px;
    }
    .modal-footer {
        padding: 16px 24px;
        background-color: #f8f9fa;
        border-top: 1px solid #eee;
    }
    .form-control:focus {
        border-color: #dfa974;
        box-shadow: 0 0 0 0.25rem rgba(223, 169, 116, 0.25);
    }
</style>
@endpush

@endsection
