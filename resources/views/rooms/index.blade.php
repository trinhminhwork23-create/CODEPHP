@extends('layouts.master')

@section('content')

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Danh sách biệt thự & phòng nghỉ</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <span>Phòng nghỉ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    {{-- 🔍 ACTIVE FILTERS DISPLAY --}}
    @if(request('adults') || request('children') || request('check_in') || request('check_out') || request('search'))
        <section class="py-3 sapa-filter-section">
            <div class="container">
                <div class="sapa-filter-container">
                    <span class="sapa-filter-title">
                        <i class="fa fa-filter sapa-filter-title-icon"></i> Bộ lọc đang áp dụng:
                    </span>
                    @if(request('search'))
                        <span class="badge sapa-badge-orange">
                            <i class="fa fa-search sapa-badge-icon"></i> Từ khóa: "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('adults'))
                        <span class="badge sapa-badge-orange">
                            <i class="fa fa-user sapa-badge-icon"></i> {{ request('adults') }} Người lớn
                        </span>
                    @endif
                    @if(request('children'))
                        <span class="badge sapa-badge-orange">
                            <i class="fa fa-child sapa-badge-icon"></i> {{ request('children') }} Trẻ em
                        </span>
                    @endif
                    @if(request('check_in') && request('check_out'))
                        <span class="badge sapa-badge-green">
                            <i class="fa fa-calendar sapa-badge-icon"></i> 
                            {{ \Carbon\Carbon::parse(request('check_in'))->format('d/m/Y') }} → {{ \Carbon\Carbon::parse(request('check_out'))->format('d/m/Y') }}
                        </span>
                    @endif
                    <a href="{{ route('rooms.index') }}" class="sapa-clear-filters">
                        <i class="fa fa-times-circle sapa-badge-icon"></i> Xóa bộ lọc
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad">
        <div class="container">
            <div class="row">
                @if($errors->any())
                    <div class="col-lg-12">
                        <div class="alert alert-danger sapa-alert-danger">
                            <ul class="mb-0" style="margin: 0; padding-left: 18px;">
                                @foreach($errors->all() as $error)
                                    <li style="font-size: 14px;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @forelse($rooms as $room)
                    <div class="col-lg-4 col-md-6">
                        <div class="room-item">
                            @php
                                $badge = "Eco-Luxury Suite";
                                if ($room->id == 1) $badge = "Luxury Eco-Villa";
                                elseif ($room->id == 2) $badge = "Được đặt nhiều nhất tuần này";
                                elseif ($room->id == 3) $badge = "Bán chạy nhất";
                                elseif ($room->id == 4) $badge = "View thung lũng cực đẹp";
                                
                                $amenities = ["View Thung lũng Mường Hoa", "Lò sưởi củi đá", "Bồn tắm gỗ Pơ-mu"];
                                if ($room->id % 2 == 0) {
                                    $amenities = ["View Đồi Thông Mờ Sương", "Ban công panorama", "Bể bơi nước nóng"];
                                }
                            @endphp
                            <div class="sapa-grid-badge-container">
                                <span class="sapa-grid-urgency-badge">{{ $badge }}</span>
                            </div>
                            <img src="{{ asset('img/rooms/room_' . $room->id . '.jpg') }}" alt="{{ $room->name }}">
                            <div class="ri-text">
                                <div class="sapa-grid-stars">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                </div>
                                <h4>{{ $room->name }}</h4>
                                <h3>{{ number_format($room->price, 0, ',', '.') }}<span> đ/Đêm</span></h3>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Diện tích:</td>
                                            <td>{{ $room->size ? $room->size . ' m²' : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Sức chứa:</td>
                                            <td>Tối đa {{ $room->capacity }} người</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Giường:</td>
                                            <td>{{ $room->bed_type ?? 'Tiêu chuẩn' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Loại phòng:</td>
                                            <td>{{ $room->category->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Đặc trưng:</td>
                                            <td>
                                                <div class="sapa-card-amenity-list">
                                                    @foreach($amenities as $amenity)
                                                        <span class="sapa-card-amenity-item"><i class="fa fa-check"></i> {{ $amenity }}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('rooms.show', [$room->id] + request()->query()) }}" class="primary-btn">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12 text-center py-5 my-5">
                        <div class="mb-4">
                            <i class="icon_error-circle_alt sapa-empty-icon"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Không tìm thấy phòng phù hợp</h4>
                        @if(request('adults') || request('children'))
                            <p class="text-secondary mt-2">
                                Hiện tại không có phòng nào phù hợp với yêu cầu:
                                <strong>{{ (int)request('adults') + (int)request('children') }} người</strong>
                                <br>Vui lòng thử lại với số lượng khách ít hơn hoặc chọn ngày khác.
                            </p>
                        @else
                            <p class="text-secondary mt-2">
                                Hiện tại không có phòng nào phù hợp với yêu cầu tìm kiếm của quý khách.<br>
                                Vui lòng thay đổi ngày nhận/trả phòng hoặc số lượng người để thử lại.
                            </p>
                        @endif
                        <a href="{{ route('home') }}" class="primary-btn mt-3 sapa-btn-retry">Tìm kiếm lại</a>
                    </div>
                @endforelse

                @if($rooms->hasPages())
                    <div class="col-lg-12">
                        <div class="room-pagination">
                            {{ $rooms->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Rooms Section End -->

@endsection

@push('styles')
<style>
    .sapa-filter-section { background-color: #f9f9f9; border-bottom: 1px solid #ebebeb; }
    .sapa-filter-container { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; }
    .sapa-filter-title { font-weight: 600; color: #19191a; font-size: 14px; }
    .sapa-filter-title-icon { margin-right: 6px; color: #dfa974; }
    .sapa-badge-orange { background-color: #dfa974; color: #ffffff; padding: 6px 12px; font-weight: 500; border-radius: 3px; font-size: 13px; }
    .sapa-badge-icon { margin-right: 4px; }
    .sapa-badge-green { background-color: #28a745; color: #ffffff; padding: 6px 12px; font-weight: 500; border-radius: 3px; font-size: 13px; }
    .sapa-clear-filters { margin-left: auto; color: #dc3545; font-weight: 600; font-size: 13px; text-decoration: none; transition: opacity 0.3s; }
    .sapa-clear-filters:hover { opacity: 0.7; }
    .sapa-alert-danger { border-radius: 4px; padding: 12px 16px; margin-bottom: 20px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
    .sapa-empty-icon { font-size: 60px; color: #dfa974; }
    .sapa-btn-retry { display: inline-block; padding: 12px 30px; }
    
    .sapa-grid-badge-container { position: absolute; z-index: 10; margin-top: 15px; margin-left: 15px; }
    .sapa-grid-urgency-badge { background: #dfa974; color: #fff; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(223, 169, 116, 0.3); }
    .sapa-grid-stars { color: #dfa974; margin-bottom: 8px; font-size: 12px; }
    .sapa-card-amenity-list { display: flex; flex-direction: column; gap: 4px; }
    .sapa-card-amenity-item { font-size: 12px; color: #c89560; font-weight: 500; }
    .sapa-card-amenity-item i { margin-right: 4px; font-size: 10px; }
    
    .room-item { position: relative; }
</style>
@endpush
