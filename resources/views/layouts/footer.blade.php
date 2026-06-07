<!-- Footer Section Begin -->
<footer class="footer-section">
    <div class="container">
        <div class="footer-text">
            <div class="row">
                <div class="col-lg-4">
                    <div class="ft-about">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('img/logojadehill.png') }}" alt="Sapa Jade Hill Resort & Spa" class="sapa-footer-logo">
                            </a>
                        </div>
                        <p>Sapa Jade Hill Resort & Spa - Nơi đồi thông mờ sương hòa quyện bản giao hưởng mây trời. Thung lũng Mường Hoa mở ra khung cảnh núi rừng hùng vĩ, nơi tâm hồn tìm về sự bình yên tuyệt đối.</p>
                        <div class="fa-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-tripadvisor"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="ft-contact">
                        <h6>Liên hệ với chúng tôi</h6>
                        <ul>
                            <li><i class="fa fa-phone sapa-footer-icon"></i>0214.371.9999</li>
                            <li><i class="fa fa-envelope sapa-footer-icon"></i>booking@sapajadehill.vn</li>
                            <li><i class="fa fa-map-marker sapa-footer-icon"></i>Thung lũng Mường Hoa, Ngõ Cầu Mây, Tổ 3, Phường Cầu Mây, Thị xã Sa Pa, Tỉnh Lào Cai, Việt Nam.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ft-newslatter">
                        <h6>Tin tức mới nhất</h6>
                        <p>Nhận thông tin cập nhật và ưu đãi mới nhất.</p>
                        <form action="#" class="fn-form">
                            <input type="text" placeholder="Email của bạn">
                            <button type="submit"><i class="fa fa-send"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <ul>
                        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Chính sách môi trường</a></li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <div class="co-text">
                        <p>Copyright © 2026 Bản quyền thuộc về Nhóm lập trình web 11.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

@push('styles')
<style>
.sapa-footer-logo { max-height: 60px; width: auto; object-fit: contain; display: block; margin-bottom: 20px; }
.sapa-footer-icon { color: #dfa974; margin-right: 8px; }
</style>
@endpush
