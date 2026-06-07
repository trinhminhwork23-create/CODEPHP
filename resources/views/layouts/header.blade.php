<div class="top-nav">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <ul class="tn-left">
                    <li><i class="fa fa-phone"></i> 0214.371.9999</li>
                    <li><i class="fa fa-envelope"></i> booking@sapajadehill.vn</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="tn-right">
                    @auth
                        @if(in_array(auth()->user()->role, ['admin', 'staff']))
                            <a href="{{ route('admin.categories.index') }}" class="bk-btn">Trang quản lý</a>
                        @endif
                        <a href="{{ route('profile.history') }}" class="bk-btn">Đơn hàng của tôi</a>
                        <div class="language-option">
                            <span>{{ auth()->user()->name }} <i class="fa fa-angle-down"></i></span>
                            <div class="flag-dropdown dropdown-menu-custom">
                                <ul>
                                    <li><a href="{{ route('profile.history') }}">Quản lý tài khoản</a></li>
                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
                                </ul>
                            </div>
                        </div>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display:none;">@csrf</form>
                    @else
                        <a href="{{ route('login') }}" class="bk-btn">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="bk-btn">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<div class="menu-item">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('img/logojadehill.png') }}" alt="Sapa Jade Hill" style="max-height: 60px;">
                    </a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="nav-menu">
                    <ul class="mainmenu">
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}"><a href="{{ route('rooms.index') }}">Phòng nghỉ</a></li>
                        <li class="{{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}">Giới thiệu</a></li>
                        <li class="{{ request()->routeIs('blog.*') ? 'active' : '' }}"><a href="{{ route('blog.index') }}">Tin tức</a></li>
                        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Liên hệ</a></li>
                    </ul>
                    <div class="nav-right">
                        <div class="nav-search-container sapa-nav-search-container">
                            <form action="{{ route('rooms.index') }}" method="GET" class="nav-search-form">
                                <input 
                                    type="text" 
                                    id="navbar-search-input" 
                                    name="search"
                                    placeholder="Tìm phòng..."
                                    autocomplete="off"
                                    class="sapa-search-input"
                                >
                                <button type="submit" class="sapa-search-btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                            <div id="search-suggestion-wrapper"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dropdown-menu-custom {
    min-width: 180px !important;
    white-space: nowrap;
}
.dropdown-menu-custom ul li a {
    display: block;
    padding: 10px 15px;
    white-space: nowrap;
}
.dropdown-menu-custom ul li a:hover {
    background-color: #f5f5f5;
}
</style>

@push('scripts')
<script>
    window.roomsSuggestionsUrl = "{{ route('rooms.suggestions') }}";
</script>
@endpush
