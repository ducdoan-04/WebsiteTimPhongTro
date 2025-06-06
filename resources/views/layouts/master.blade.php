<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tìm trọ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="text/css" href="/images/gps.png">
    <!-- CSS Bootrap -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{asset('')}}">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-3/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/awesome/css/fontawesome-all.css">

    <link rel="stylesheet" href="assets/toast/toastr.min.css">
    <!-- js  -->
    <script src="assets/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/myjs.js"></script>
    <script src="assets/huongdan.js"></script>
    <link rel="stylesheet" href="assets/selectize.default.css" data-theme="default">

    <!-- CSS FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="assets/styleBoxSearch.css">
    <link rel="stylesheet" href="assets/footer.css">
    <link rel="stylesheet" href="assets/thongtinphong.css">
    <link rel="stylesheet" href="assets/SliderHomeHostel.css">
    <link rel="stylesheet" href="assets/Editprofile.css">
    <link rel="stylesheet" href="assets/huongdan.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
    <!-- file input  -->
    <script src="assets/js/fileinput/fileinput.js" type="text/javascript"></script>
    <script src="assets/js/fileinput/vi.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/fileinput.css">
    <!-- 	 -->
    <script src="assets/pgwslider/pgwslider.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/pgwslider/pgwslider.min.css">
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/sortable.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/purify.min.js" type="text/javascript"></script> -->

    <link rel="stylesheet" href="assets/bootstrap/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/bootstrap/bootstrap-select.min.js"></script>
    <!--  -->

    <!-- Thêm thư viện Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Thêm thư viện Leaflet Search -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- -------------------------------- -->
    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script> -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Include Krajee Bootstrap File Input CSS and jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
    <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=""><img src="images/logo.png" style="margin-top:-5px;height:70px;"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    @foreach($categories as $category)
                    <li><a href="category/{{$category->id}}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>

                @if(Auth::user())
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn-dangtin" href="user/dangtin" style="color='red';"><i class="fas fa-edit"></i> Đăng
                            tin ngay</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Xin chào! {{Auth::user()->name}}
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="margin-right: 12px; ">
                            <li><a href="user/profile">Xem hồ sơ</a></li>
                            <li><a href="user/quanlytin">Quản lý tin</a></li>
                            <li><a href="user/huongdan">Hướng dẫn</a></li>
                            <li><a href="user/savenews">Tin đã lưu</a></li>
                            <li><a href="user/dangtin">Đăng tin</a></li>
                            <li><a href="user/logout">Thoát</a></li>
                        </ul>
                    </li>

                </ul>

                @else
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn-dangtin" href="user/dangtin"><i class="fas fa-edit"></i> Đăng tin ngay</a></li>
                    <li><a href="user/login"><i class="fas fa-user-circle"></i> Đăng Nhập</a></li>
                    <li><a href="user/register"><i class="fas fa-sign-in-alt"></i> Đăng Kí</a></li>
                </ul>
                @endif
            </div>
        </div>
    </nav>

    @yield('content')
    <div class="gap"></div>

    <footer id="footer" class="show">
        <div class="footer-info">
            <div class="container">
                <div class="inner">


                    <a class="footer-logo" href="../HTML/Trangchu.php"><img src="images/logo.png"></a>

                    <div class="content">
                        <div class="block block-1">
                            <h2>Về chúng tôi</h2>
                            <ul>
                                <li><a href="#" target="_blank">Quy chế hoạt động</a></li>
                                <li><a href="#" target="_blank">Chính sách bảo mật</a></li>
                                <li><a href="#" target="_blank">Giải quyết khiếu nại</a></li>
                                <li><a href="#" target="_blank">Điều khoản &amp; Cam kết</a></li>

                            </ul>
                        </div>
                        <div class="block block-2">
                            <h2>Hệ thống</h2>
                            <ul>
                                <li><a href="../HTML/DanhSach.html#tab2_1" target="_blank">Phòng trọ</a></li>
                                <li><a href="../HTML/DanhSach.html#tab2_2" target="_blank">Nhà, căn hộ cho thuê</a></li>
                                <li><a href="../HTML/DanhSach.html#tab2_3" target="_blank">Tìm ở ghép</a></li>
                            </ul>
                        </div>
                        <div class="block block-3">
                            <h2>Hướng dẫn</h2>
                            <ul>
                                <li><a href="../HTML/Huongdan.html#tab_7" target="_blank">Tạo tài khoản</a></li>
                                <li><a href="../HTML/Huongdan.html#tab_1" target="_blank">Tìm trọ</a></li>
                                <li><a href="../HTML/Huongdan.html#tab_3" target="_blank">Đăng tin</a></li>
                            </ul>
                        </div>


                        <div class="block block-4">
                            <h2>Kết nối với chúng tôi</h2>
                            <ul>
                                <li>Hotline: <a href="tel:0919261712">091.926.1712</a></li>

                                <li>Email: <a href="mailto:doanhd.22it@vku.udn.vn"
                                        target="_blank">doanhd.22it@vku.udn.vn</a></li>
                                <li class="social">
                                    <a href="https://www.facebook.com" target="_blank">
                                        <img src="images/image-icon-logo/fb_icon.svg" alt="Facebook"
                                            data-pagespeed-url-hash="1352054977">
                                    </a>
                                    <a href="https://www.youtube.com/" target="_blank">
                                        <img src="Images/image-icon-logo/ytb_icon.svg" alt="Youtube"
                                            data-pagespeed-url-hash="1803729568">
                                    </a>
                                    <a href="https://www.tiktok.com/" target="_blank">
                                        <img src="Images/image-icon-logo/tik_tok_icon.svg" alt="TikTok"
                                            data-pagespeed-url-hash="152980296">
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="block block-5">
                            <h2>PHƯƠNG THỨC THANH TOÁN</h2>
                            <ul>
                                <div style="display: flex;">
                                    <li><span class="bds_icon icon_visa"></span></li>
                                    <li><span class="bds_icon icon_mastercard"></span></li>
                                    <li><span class="bds_icon icon_jcb"></span></li>
                                </div>
                                <div style="display: flex;">
                                    <li><span class="bds_icon icon_internet_banking"></span></li>
                                    <li><span class="bds_icon icon_momo"></span></li>
                                    <li><span class="bds_icon icon_tienmat"></span></li>
                                </div>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                Copyright © 2023 HDD
            </div>
        </div>
        <div class="footer-company">
            <div class="container">
                <p class="text-center">
                    <a href="https://goo.gl/maps/95au9CryuBGhUe1i6" target="_blank">Địa chỉ cơ quan: 470 Trần Đại Nghĩa
                        , Hòa Quý, Ngũ Hành Sơn, TP Đà Nẵng.</a>
                </p>
            </div>
        </div>
    </footer>
    <script type="text/javascript" src="assets/toast/toastr.min.js"></script>
</body>

</html>