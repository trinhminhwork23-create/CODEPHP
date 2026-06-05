<!-- Header Section Begin -->
<header class="header-section">
    <div class="top-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="tn-left">
                        <li><i class="fa fa-phone"></i> (12) 345 67890</li>
                        <li><i class="fa fa-envelope"></i> info.colorlib@gmail.com</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="tn-right">
                        <div class="top-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-tripadvisor"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                            @auth
                                <a href="{{ route('profile.history') }}" class="bk-btn" style="background: #19191a; border-color: #19191a; margin-right: 5px; color: #ffffff;">Lịch sử đặt phòng</a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="bk-btn" style="background: #dc3545; border-color: #dc3545; color: #ffffff;">Đăng xuất</a>
                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('auth.login') }}" class="bk-btn" style="background: transparent; color: #19191a; border: 1px solid #dfa974; margin-right: 5px;">Đăng nhập</a>
                                <a href="{{ route('auth.register') }}" class="bk-btn">Đăng ký</a>
                            @endauth
                        <div class="language-option">
                            <img src="{{ asset('img/flag.jpg') }}" alt="">
                            <span>VI <i class="fa fa-angle-down"></i></span>
                            <div class="flag-dropdown">
                                <ul>
                                    <li><a href="#">EN</a></li>
                                    <li><a href="#">Fr</a></li>
                                </ul>
                            </div>
                        </div>
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
                            <img src="{{ asset('img/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="nav-menu">
                        <nav class="mainmenu">
                            <ul>
                                <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}"><a href="{{ route('rooms.index') }}">Phòng nghỉ</a></li>
                                <li class="{{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}">Giới thiệu</a></li>
                                <li><a href="#">Trang</a>
                                    <ul class="dropdown">
                                        <li><a href="{{ route('rooms.show', 1) }}">Chi tiết phòng</a></li>
                                        <li><a href="{{ route('blog.show', 1) }}">Chi tiết tin tức</a></li>
                                        <li><a href="{{ route('rooms.show', 2) }}">Phòng Gia đình</a></li>
                                        <li><a href="{{ route('rooms.show', 3) }}">Phòng Cao cấp</a></li>
                                    </ul>
                                </li>
                                <li class="{{ request()->routeIs('blog.*') ? 'active' : '' }}"><a href="{{ route('blog.index') }}">Tin tức</a></li>
                                <li class="{{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Liên hệ</a></li>
                            </ul>
                        </nav>
                        <div class="nav-right search-switch">
                            <i class="icon_search"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->
