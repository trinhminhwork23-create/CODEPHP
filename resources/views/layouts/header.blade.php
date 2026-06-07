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
                            <div style="display: inline-flex; align-items: center; gap: 8px;">
                                {{-- Nút Trang Quản lý: chỉ hiện với admin và staff --}}
                                @if(in_array(auth()->user()->role, ['admin', 'staff']))
                                    <a href="{{ route('admin.categories.index') }}" class="bk-btn" style="background: #c9a227; border-color: #c9a227; color: #fff; font-weight: 700; letter-spacing: 1px; white-space: nowrap;">
                                        <i class="fa fa-cog" style="margin-right: 4px;"></i> TRANG QUẢN LÝ
                                    </a>
                                @endif

                                {{-- Nút Đơn hàng của tôi --}}
                                <a href="{{ route('profile.history') }}" class="bk-btn" style="background: #dfa974; border-color: #dfa974; color: #fff; font-weight: 600; letter-spacing: 0.8px; white-space: nowrap;">
                                    <i class="fa fa-shopping-bag" style="margin-right: 5px;"></i> ĐƠN HÀNG CỦA TÔI
                                </a>

                                {{-- Dropdown Xin chào --}}
                                <div class="user-dropdown" style="position: relative; display: inline-block;">
                                    <button class="bk-btn" style="background: #19191a; border-color: #19191a; color: #fff; cursor: pointer; white-space: nowrap;" onclick="this.nextElementSibling.classList.toggle('open')">
                                        <i class="fa fa-user-circle" style="margin-right: 5px;"></i>
                                        Xin chào, {{ auth()->user()->name }}
                                        <i class="fa fa-angle-down" style="margin-left: 4px;"></i>
                                    </button>
                                    <div class="user-dropdown-menu" style="display: none; position: absolute; right: 0; top: 110%; background: #fff; min-width: 200px; border: 1px solid #ebebeb; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,.12); z-index: 9999;">
                                        <a href="{{ route('profile.history') }}" style="display: block; padding: 10px 18px; color: #19191a; font-size: 14px; border-bottom: 1px solid #f0f0f0; text-decoration: none;">
                                            <i class="fa fa-user" style="margin-right: 8px; color: #dfa974;"></i> Quản lý tài khoản
                                        </a>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="display: block; padding: 10px 18px; color: #dc3545; font-size: 14px; text-decoration: none;">
                                            <i class="fa fa-sign-out" style="margin-right: 8px;"></i> Đăng xuất
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        @else
                            <a href="{{ route('login') }}" class="bk-btn" style="background: transparent; color: #19191a; border: 1px solid #dfa974; margin-right: 5px;">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="bk-btn">Đăng ký</a>
                        @endauth

                        <style>
                            .user-dropdown-menu.open { display: block !important; }
                            .user-dropdown-menu a:hover { background: #f8f4ee; }
                        </style>
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
                        <div class="nav-right">
                            <div class="nav-search-container" style="position: relative; display: inline-block;">
                                <form action="{{ route('rooms.index') }}" method="GET" class="nav-search-form">
                                    <input 
                                        type="text" 
                                        id="navbar-search-input" 
                                        name="search"
                                        placeholder="Tìm phòng..."
                                        autocomplete="off"
                                        style="width: 220px; height: 40px; padding: 0 40px 0 15px; border: 1px solid #ebebeb; border-radius: 20px; font-size: 14px; color: #19191a; transition: all 0.3s;"
                                    >
                                    <button type="submit" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #dfa974; cursor: pointer; padding: 8px;">
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
</header>
<!-- Header End -->
