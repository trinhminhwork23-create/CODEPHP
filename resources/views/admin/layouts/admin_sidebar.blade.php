<!-- SIDEBAR -->
<aside id="sidebar" class="sidebar">
    <div class="logo-area">
        <a href="{{ route('admin.dashboard') }}" class="d-inline-flex"><img src="{{ asset('admin/assets/images/logo-icon.svg') }}" alt="" width="24">
            <span class="logo-text ms-2"> <img src="{{ asset('admin/assets/images/logo.svg') }}" alt=""></span>
        </a>
    </div>
    <ul class="nav flex-column">
        <li class="px-4 py-2"><small class="nav-text">Quản lý chính</small></li>
        <li><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="ti ti-home"></i><span
                    class="nav-text">Bảng điều khiển tổng quan</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}"><i class="ti ti-bed"></i><span
                    class="nav-text">Quản lý phòng</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="ti ti-category"></i><span
                    class="nav-text">Loại phòng</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}"><i class="ti ti-calendar-event"></i><span class="nav-text">Đơn đặt phòng</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="ti ti-users"></i><span class="nav-text">Tài khoản</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}"><i class="ti ti-star"></i><span class="nav-text">Đánh giá</span></a>
        </li>

        <li class="px-4 pt-4 pb-2"><small class="nav-text">Tài khoản</small></li>
        <li><a class="nav-link" href="{{ route('home') }}"><i class="ti ti-world"></i><span class="nav-text">Về trang chủ</span></a>
        </li>
        <li>
            <form method="POST" action="{{ route('auth.logout') }}" class="d-inline">
                @csrf
                <a class="nav-link" href="{{ route('auth.logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="ti ti-logout"></i><span class="nav-text">Đăng xuất</span></a>
            </form>
        </li>
    </ul>
</aside>
