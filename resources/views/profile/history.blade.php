@extends('layouts.master')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Lịch sử đặt phòng</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <span>Hồ sơ cá nhân</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- History Section Begin -->
    <section class="history-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="history-table table-responsive">
                        <table class="table table-bordered table-hover text-center" style="border: 1px solid #ebebeb;">
                            <thead style="background-color: #dfa974; color: #ffffff;">
                                <tr>
                                    <th style="font-weight: 500; padding: 15px;">Mã đơn</th>
                                    <th style="font-weight: 500; padding: 15px;">Tên phòng</th>
                                    <th style="font-weight: 500; padding: 15px;">Ngày nhận</th>
                                    <th style="font-weight: 500; padding: 15px;">Ngày trả</th>
                                    <th style="font-weight: 500; padding: 15px;">Tổng tiền</th>
                                    <th style="font-weight: 500; padding: 15px;">Trạng thái</th>
                                    <th style="font-weight: 500; padding: 15px;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings ?? [ (object)[ 'id' => 1, 'room_id' => 1, 'room' => (object)['name' => 'Phòng Premium King'], 'check_in' => date('Y-m-d'), 'check_out' => date('Y-m-d', strtotime('+1 day')), 'total_money' => 159.00, 'status' => 2 ] ] as $booking)
                                    <tr>
                                        <td class="align-middle" style="color: #19191a; font-weight: 500;">{{ $booking->id }}</td>
                                        <td class="align-middle" style="color: #707079;">{{ $booking->room->name ?? 'Phòng Premium King' }}</td>
                                        <td class="align-middle" style="color: #707079;">{{ isset($booking->check_in) ? \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') : '' }}</td>
                                        <td class="align-middle" style="color: #707079;">{{ isset($booking->check_out) ? \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') : '' }}</td>
                                        <td class="align-middle" style="color: #19191a; font-weight: 500;">${{ number_format($booking->total_money ?? 0, 2) }}</td>
                                        <td class="align-middle">
                                            @if(($booking->status ?? 0) == 0)
                                                <span class="badge" style="background-color: #ffc107; color: #212529; padding: 8px 12px; font-weight: 500;">Chờ duyệt</span>
                                            @elseif(($booking->status ?? 0) == 1)
                                                <span class="badge" style="background-color: #17a2b8; color: #ffffff; padding: 8px 12px; font-weight: 500;">Đã xác nhận</span>
                                            @elseif(($booking->status ?? 0) == 2)
                                                <span class="badge" style="background-color: #28a745; color: #ffffff; padding: 8px 12px; font-weight: 500;">Đã hoàn thành</span>
                                            @elseif(($booking->status ?? 0) == 3)
                                                <span class="badge" style="background-color: #dc3545; color: #ffffff; padding: 8px 12px; font-weight: 500;">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if(($booking->status ?? 0) == 2)
                                                <a href="{{ route('rooms.show', $booking->room_id ?? 1) }}#reviews" class="primary-btn" style="padding: 10px 20px; font-size: 13px;">Đánh giá & Bình luận</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center" style="padding: 30px; color: #707079;">Quý khách chưa có lịch sử đặt phòng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- History Section End -->
@endsection
