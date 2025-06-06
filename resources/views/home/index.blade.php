@extends('layouts.master')
@section('content')
<?php 
function limit_description($string){
	$string = strip_tags($string);
	if (strlen($string) > 100) {

	    // truncate string
	    $stringCut = substr($string, 0, 100);
	    $endPoint = strrpos($stringCut, ' ');

	    //if the string doesn't contain any space then it will cut without word basis.
	    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
	    $string .= '...';
	}
	return $string;
}
function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'năm',
		'm' => 'tháng',
		'w' => 'tuần',
		'd' => 'ngày',
		'h' => 'giờ',
		'i' => 'phút',
		's' => 'giây',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' trước' : 'Vừa xong';
}
?>
<div class="container-fluid" style="padding-left: 10px;padding-right: 0px;">
    <div class="search-map hidden-xs">
        <div id="map"></div>
        <nav class="block-search main">
            <div class="container-inner">
                <div class="box-search">
                    <div class="block-outer">
                        <!-- <div id="flat"></div>
									<div id="lng"></div> -->

                        <!-- TIM KIEM -->
                        <!-- <form onsubmit="return false" class="block-inner">
										<input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                        <div class="block-inner">
                            <div class="box-search-balloon">

                                <div class="box-search stick main">
                                    <div id="top-search" name="top-search" method="get" action="">
                                        <label class="opt search-form_label">
                                            <form action="{{ route('search') }}" method="POST"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="text" name="keyword" id="keyword"
                                                    class="keyword search-form_input" placeholder="Tìm kiếm nhanh"
                                                    autocomplete="off">
                                                <input type="submit" id="submit" value="."
                                                    class="btn btn-primary button search-form_submit">
                                            </form>
                                            <script>
                                            $(document).ready(function() {
                                                $('#submit').on('click', function() {
                                                    $('#searchForm').submit();
                                                });
                                                $('#keyword').on('keydown', function(event) {
                                                    if (event.keyCode === 13) {
                                                        event.preventDefault();
                                                        $('#submit').click();
                                                    }
                                                });
                                            });
                                            </script>
                                        </label>

                                        <div id="search-form_result">
                                            <div class="name"></div>
                                            <div class="district"></div>
                                            <div class="street"></div>
                                            <div class="address"></div>
                                        </div>
                                    </div>
                                </div>
                                <form onsubmit="return false">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <ul class="form-group row">
                                        <li>
                                            <div class="col-xs-6">
                                                <select class="selectpicker" data-live-search="true"
                                                    id="selectdistrict">
                                                    @foreach($district as $quan)
                                                    <option data-tokens="{{$quan->slug}}" value="{{ $quan->id }}">
                                                        {{ $quan->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="col-xs-6">
                                                <select class="selectpicker" data-live-search="true"
                                                    id="selectcategory">
                                                    @foreach($categories as $category)
                                                    <option data-tokens="{{ $category->slug }}"
                                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="col-xs-6">
                                                <select class="selectpicker" id="selectprice" data-live-search="true">
                                                    <option data-tokens="khoang gia" min="1" max="10000000">Khoảng giá
                                                    </option>
                                                    <option data-tokens="Tu 500.000 VNĐ - 700.000 VNĐ" min="500000"
                                                        max="700000">Từ 500.000 VNĐ - 700.000 VNĐ</option>
                                                    <option data-tokens="Tu 700.000 VNĐ - 1.000.000 VNĐ" min="700000"
                                                        max="1000000">Từ 700.000 VNĐ - 1.000.000 VNĐ</option>
                                                    <option data-tokens="Tu 1.000.000 VNĐ - 1.500.000 VNĐ" min="1000000"
                                                        max="1500000">Từ 1.000.000 VNĐ - 1.500.000 VNĐ</option>
                                                    <option data-tokens="Tu 1.500.000 VNĐ - 3.000.000 VNĐ" min="1500000"
                                                        max="3000000">Từ 1.500.000 VNĐ - 3.000.000 VNĐ</option>
                                                    <option data-tokens="Tren 3.000.000 VNĐ" min="3000000"
                                                        max="10000000">Trên 3.000.000 VNĐ</option>
                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="col-xs-6">
                                                <select class="selectpicker" id="selectarea" data-live-search="true">
                                                    <option data-tokens="dien tich" min="1" max="10000000">Diện tích
                                                    </option>
                                                    <option data-tokens="Tu 1 M² - 30 M²" min="1" max="30">Từ 1 M² - 30
                                                        M²</option>
                                                    <option data-tokens="Tu 30 M² - 50 M²" min="30" max="50">Từ 30 M² -
                                                        50 M²</option>
                                                    <option data-tokens="Tu 50 M² - 70 M²" min="50" max="70">Từ 50 M² -
                                                        70 M²</option>
                                                    <option data-tokens="Tu 70 M² - 100 M²" min="70" max="100">Từ 70 M²
                                                        - 100 M²</option>
                                                    <option data-tokens="Tu 100 M² - 150 M²" min="100" max="150">Từ 100
                                                        M² - 150 M²</option>
                                                    <option data-tokens="Tu 150 M² - 200 M²" min="150" max="200">Từ 150
                                                        M² - 200 M²</option>
                                                    <option data-tokens="Tu 250 M² - 500 M²" min="250" max="500">Từ 250
                                                        M² - 500 M²</option>
                                                    <option data-tokens="Tu 500 M² - 1000 M²" min="500" max="1000">Từ
                                                        500 M² - 1000 M²</option>
                                                    <option data-tokens="Tu 1000 M² - 2000 M²" min="1000" max="2000">Từ
                                                        1000 M² - 2000 M²</option>
                                                    <option data-tokens="Tren 2000 M²" min="2000" max="10000000">Trên
                                                        2000 M²</option>
                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="col-xs-6">
                                                <button class="btn btn-success" onclick="searchMotelajax()">Tìm
                                                    kiếm</button>
                                            </div>
                                        </li>
                                    </ul>
                                    <!-- <div class="form-group row">
		
											</div> -->
                            </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </nav>
    </div>
</div>

<div class="container">
    <div class="row" style="margin-top: 90px; margin-bottom: 10px">
        <div class="col-md-6">
            <div class="asks-first" style="border-radius: 10px;">
                <div class="asks-first-circle" style="margin-top:0px;">
                    <span class="fa fa-search"></span>
                </div>
                <div class="asks-first-info">
                    <h2>Bạn tìm trọ khó có tôi lo</h2>
                    <p>Tiết kiệm nhiều thời gian cho bạn với giải pháp và công nghệ mới</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="asks-first2" style="border-radius: 10px;">
                <div class="asks-first-circle" style="margin-top:0px;">
                    <!-- <span class="fas fa-hourglass-start"></span> -->
                    <span class="fas fa-lock"></span>
                </div>
                <div class="asks-first-info">
                    <h2>An Toàn - Bảo Mật</h2>
                    <p>Đội ngũ Quản trị viên kiểm duyệt hiệu quả. Chất Lượng đem lại sự tin tưởng.</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="title-comm"><span class="title-holder">PHÒNG TRỌ HOT</span></h3>
    <div class="row room-hot">
        @foreach($hot_motelroom as $room)
        <?php 
							$img_thumb = json_decode($room->images,true);
							
						 ?>
        <div class="col-md-4 col-sm-6">
            <div class="room-item">
                <div class="image layout-1">
                    <div class="wrap-img layout-1"
                        style="background: url(uploads/images/<?php echo $img_thumb[0]; ?>) center;     background-size: cover;">
                        <img src="" class="lazyload img-responsive">
                        <div class="category">
                            <a href="category/{{ $room->category->id }}">{{ $room->category->name }}</a>
                            <span class="pull-right"><i class="fas fa-eye"></i> Lượt xem:
                                <b>{{ $room->count_view }}</b></span>
                        </div>
                    </div>
                </div>
                <div class="room-detail">
                    <h4><a href="phongtro/{{ $room->slug }}">{{ $room->title }}</a></h4>
                    <div class="room-meta">
                        <span><i class="fas fa-user-circle"></i> Người đăng: <a href="/">
                                {{ $room->user->name }}</a></span>
                        <span><i class="far fa-stop-circle"></i> Diện tích: <b>{{ $room->area }}
                                m<sup>2</sup></b></span>
                    </div>
                    <div class="room-description"><i class="fas fa-audio-description"></i>
                        {{ limit_description($room->description) }}</div>
                    <div class="room-info">


                        <div class="location-area">
                            <!-- Địa chỉ:  -->
                            <dl class="address">
                                <!-- <i class="fas fa-map-marker"></i> -->
                                <dt> {{ $room->address }}</dt>
                            </dl>
                        </div>
                        <div style="color: #e74c3c; display:flex; justify-content: space-between;" class="contact">
                            <div class="price">
                                <i class="far fa-money-bill-alt"></i>Giá:
                                <b> {{ number_format($room->price) }} VNĐ</b>
                            </div>
                            <span class="pull-right" style="color: #888">
                                <i class="far fa-clock"></i>
                                <?php 
														echo time_elapsed_string($room->created_at);
														?>
                            </span>
                        </div>

                    </div>
                </div>

            </div>


        </div>
        @endforeach


    </div>
</div>

<div class="container">
    <h3 class="title-comm"><span class="title-holder">DANH SÁCH PHÒNG TRỌ</span></h3>





    <div class="row">
        <div class="room room-list-right" id="center">
            <div class="col-md-8 main-list">
                @foreach($listmotelroom as $room)
                <?php 
												$img_thumb = json_decode($room->images,true);
											?>
                <div class="room-item-vertical">
                    <div class="row room-item-boder">
                        <div class="col-md-4 image">
                            <div class="wrap-img-vertical"
                                style="background: url(uploads/images/<?php echo $img_thumb[0]; ?>) center;     background-size: cover;">
                                <!-- <div class="category">
																<a href="category/{{ $room->category->id }}">{{ $room->category->name }}</a>
															</div> -->
                            </div>
                        </div>
                        <div class="col-md-8 room-detail info">
                            <!-- <div class="room-detail"> -->
                            <div class="category star">
                                <span class="local">
                                    <a href="category/{{ $room->category->id }}">{{ $room->category->name }}</a>
                                </span>
                                <span class="pull-right"><i class="fas fa-eye"></i> Lượt xem:
                                    <b>{{ $room->count_view }}</b></span>

                            </div>
                            <h4 class="title-category layout-1"><a
                                    href="phongtro/{{ $room->slug }}">{{ $room->title }}</a></h4>
                            <div class="room-meta">
                                <span><i class="fas fa-user-circle"></i> Người đăng: {{ $room->user->name }}</span>
                                <span><i class="far fa-stop-circle"></i> Diện tích: <b>{{ $room->area }}
                                        m<sup>2</sup></b></span>
                            </div>
                            <div class="room-description" style="text-align: left;">

                            </div>
                            <div class="location-area">
                                <dl class="address">
                                    <dt>
                                        <i class="fas fa-map-marker"></i> Địa chỉ: {{ $room->address }}
                                    </dt>
                                </dl>
                            </div>
                            <div class="room-info">
                                <div style="color: #e74c3c">
                                    <div class="price" style="float: left !important;"><i
                                            class="far fa-money-bill-alt"></i> <b>{{ number_format($room->price) }}</b>
                                    </div>
                                    <!-- <span class="pull-right"><i class="fas fa-eye"></i><b>{{ $room->count_view }}</b></span> -->
                                    <span class="pull-right"><i class="far fa-clock"></i>
                                        <?php echo time_elapsed_string($room->created_at); ?></span>
                                </div>

                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
                @endforeach
                <ul class="pagination pull-right">
                    @if($listmotelroom->currentPage() != 1)
                    <li><a href="{{ $listmotelroom->url($listmotelroom->currentPage() -1) }}">Trước</a></li>
                    @endif
                    @for($i= 1 ; $i<= $listmotelroom->lastPage(); $i++)
                        <li class=" {{ ($listmotelroom->currentPage() == $i )? 'active':''}}">
                            <a href="{{ $listmotelroom->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor
                        @if($listmotelroom->currentPage() != $listmotelroom->lastPage())
                        <li><a href="{{ $listmotelroom->url($listmotelroom->currentPage() +1) }}">Sau</a></li>
                        @endif
                </ul>
            </div>
        </div>
        <div class="col-md-4" style="margin-top: 0px;">
            <!-- <img src="images/banner-1.png" width="100%" style="border-radius: 10px;"> -->
            <img src="images/bg-ads-1.png" width="100%" style="border-radius: 10px;">
            <img src="images/bg-ads-2.png" width="100%" style="border-radius: 10px; margin-top:42px;">
        </div>

    </div>


</div>
<!-- Quận nổi bật -->
<div class="section box box-grid-provice" style="margin-top: 1px; padding-top:0px;">
    <div class="container">
        <div class="box box-province">
            <div class="box-header">
                <h3 class="title-comm"><span class="title-holder">QUẬN NỔI BẬT</span></h3>
            </div>
            <!-- @foreach($district as $districts)
									<li><a href="district/{{$districts->id}}">{{ $districts->name }}</a></li>
								@endforeach -->
            <div class="box-body">
                <a href="district/5" class="item">
                    <div class="item-image" style="background-image: url('../Images/image-tp-hot/lienchieu.jpg');">
                    </div>
                    <div class="item-content">
                        <div class="inner-content">
                            <div class="title">Liên Chiểu</div>
                            <p>10 tin trọ</p>
                        </div>
                    </div>
                </a>

                <a href="district/1" class="item">
                    <div class="item-image" style="background-image: url('../Images/image-tp-hot/da-nang.png');"></div>
                    <div class="item-content">
                        <div class="inner-content">
                            <div class="title">Hải Châu</div>
                            <p>8 tin trọ</p>
                        </div>
                    </div>
                </a>

                <a href="district/4" class="item">
                    <div class="item-image" style="background-image: url('../Images/image-tp-hot/nguhanhson.png');">
                    </div>
                    <div class="item-content">
                        <div class="inner-content">
                            <div class="title">Ngũ Hành Sơn</div>
                            <p>6 tin trọ</p>
                        </div>
                    </div>
                </a>
                <a href="district/6" class="item">
                    <div class="item-image" style="background-image: url('../Images/image-tp-hot/camle.jpg');"></div>
                    <div class="item-content">
                        <div class="inner-content">
                            <div class="title">Cẩm lệ</div>
                            <p>5 tin trọ</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</div>
<!-- THÔNG TIN LIÊN HỆ -->
<div class="section box box-contact" style="margin-top: 1px; padding-top:0px; padding-bottom:0px;">
    <div class="container">
        <div class="box-header">
            <h1 class="box-title text-center text-upper text-black">Hỗ trợ khách hàng</h1>
        </div>
        <div class="description d-flex">
            <p class="text-center">Bạn cần hỗ trợ <span class="highlight">Tìm kiếm, Đăng tin, Thanh toán?</span> Liên hệ
                với chúng tôi ngay qua các hình thức:</p>
        </div>
        <div class="box-body">

            <div class="inner section">
                <div class="item" data-aos="fade-up">
                    <div class="image"><img src="../Images/IMAGE_HOME_PHONG/logo_Contactt/mail.svg"></div>
                    <div class="content">
                        <div class="title">Email</div>
                        <div class="description">
                            <p>Chúng tôi sẽ trả lời thắc mắc của bạn trong vòng 24 giờ.</p>
                            <a href="mailto:doanhd.22it@vku.udn.vn" target="_blank">Email ngay</a>
                        </div>
                    </div>
                </div>

                <div class="item" data-aos="fade-up">
                    <div class="image"><img src="../Images/IMAGE_HOME_PHONG/logo_Contactt/call.svg"></div>
                    <div class="content">
                        <div class="title">Hotline 24/7</div>
                        <div class="description">
                            <p>Điện thoại viên luôn sẵn sàng giải đáp các thắc mắc của bạn.</p>
                            <a href="tel:0919261712" target="_blank">Gọi ngay</a>
                        </div>
                    </div>
                </div>

                <div class="item" data-aos="fade-up">
                    <div class="image"><img src="../Images/IMAGE_HOME_PHONG/logo_Contactt/messenger.svg"></div>
                    <div class="content">
                        <div class="title">Facebook</div>
                        <div class="description">
                            <p>Nhắn tin với chúng tôi trên nền tảng facebook messenger</p>
                            <a href="https://m.me/doan.12.02.04/" target="_blank">Gửi tin nhắn</a>
                        </div>
                    </div>
                </div>

                <div class="item" data-aos="fade-up">
                    <div class="image"><img src="../Images/IMAGE_HOME_PHONG/logo_Contactt/zalo.svg"></div>
                    <div class="content">
                        <div class="title">Zalo</div>
                        <div class="description">
                            <p>Nhắn tin hoặc gọi cho chúng tôi trên nền tảng Zalo</p>
                            <a href="https://zalo.me/0919261712" target="_blank">Liên hệ ngay</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ĐÁNH GIÁ WEBSITE CỦA NGƯỜI DÙNG -->
<div class="section box box-guest-review" style="margin-top: 1px; padding-top:0px; ">
    <div class="container">
        <div class="box-header">
            <h3 class="title-comm"><span class="title-holder">Đánh giá của người dùng</span></h3>
        </div>

        <div class="container-wrapper">
            <div class="slick-track1" id="comment-contentView">
                @foreach($viewcmt as $comm)
                <div class="item slick-slide slick-active" index="<?php echo $comm->id;?>" style="width: 370px;">

                    <div class="content">
                        <div class="info">
                            <div class="image"
                                style="background-image: url('uploads/avatars/<?php echo $comm->user->avatar;?>');">
                                <img src="uploads/avatars/<?php echo $comm->user->avatar;?>">
                            </div>
                            <div class="infor-inner">
                                <p class="name">{{$comm->cus->name}}</p>
                                <p class="position"> Đà Nẵng</p>
                            </div>
                        </div>
                        <p class="text-left" style="text-align:center;">{{$comm->content}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!------ form comment ------>
    <div class="comment-container">
        <div class="container">
            <div class="comment-review">
                @if(Auth::user())
                <form action="" method="POST" role="form">
                    <legend style="color:#5f5d5d; width:60%;">Đánh giá về website</legend>

                    <div class="form-group">
                        <label for="">Nội dung bình luận <sup style="color:red;">*</sup></label>

                        <textarea id="comment-content" class="form-control" placeholder="Nhập bình luận của bạn..."
                            style="width:50% !important;"></textarea>
                        <!-- required ="required" -->
                        <small id="comment-error" class="help-blog"></small>
                    </div>
                    <button type="button" class="btn btn-primary" id="btn-comment-2">Gửi bình luận</button>
                </form>
                @else
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modelId"> Đăng nhập để
                    bình luận</button>
                @endif
                <br>
                <div class="media" style="display:none;">
                    <a class="pull-left" href="#">

                        <img class="media-object" src="uploads/avatars/avatar-hoducdoan-1701847956.jpg" width=50;
                            alt="Image">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Media heading</h4>
                        <p>Text goes here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog odal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Đăng nhập ngay</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error">

                </div>


                <form action="" method="POST" role="form">

                    <div class="form-group">
                        <label for="">Tài khoản</label>
                        <input type="text" class="form-control" size="52" id="txtuser"
                            placeholder="Tài khoản đăng nhập hệ thống">
                    </div>
                    <div class="form-group">
                        <label for="">Mật khẩu</label>
                        <input type="password" class="form-control" size="52" id="txtpass" placeholder="Mật khẩu">
                    </div>


                    <button type="button" class="btn btn-primary btn-block" id="btn-login">Đăng Nhập Ngay</button>
                    <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                </form>

            </div>

        </div>
    </div>
</div>

<!-- JS -->
<script src="assets/js/sliderHome.js" defer></script>
<!--  -->

<script>
var map;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 16.070372,
            lng: 108.214388
        },
        zoom: 15,
        draggable: true
    });
    /* Get latlng list phòng trọ */
    <?php
							$arrmergeLatln = array();
							foreach ($map_motelroom as $room) {
								$arrlatlng = json_decode($room->latlng,true);
								$arrImg = json_decode($room->images,true);
								$arrmergeLatln[] = ["slug"=> $room->slug ,"lat"=> $arrlatlng[0],"lng"=> $arrlatlng[1],"title"=>$room->title,"address"=> $room->address,"image"=>$arrImg[0],"phone"=>$room->phone];
								
							}

							$js_array = json_encode($arrmergeLatln);
							echo "var javascript_array = ". $js_array . ";\n";

							?>
    /* ---------------  */
    console.log(javascript_array);

    var listphongtro = [{
            lat: 16.067011,
            lng: 108.214388,
            title: '33 Hoàng diệu',
            content: 'bbbb'
        },
        {
            lat: 16.066330603904397,
            lng: 108.2066632380371,
            title: '33 Hoàng diệu',
            content: 'bbbb'
        }
    ];
    console.log(javascript_array);

    for (i in javascript_array) {
        var data = javascript_array[i];
        var latlng = new google.maps.LatLng(data.lat, data.lng);
        var phongtro = new google.maps.Marker({
            position: latlng,
            map: map,
            title: data.title,
            icon: "images/gps.png",
            content: 'dgfdgfdg'
        });
        var infowindow = new google.maps.InfoWindow();
        (function(phongtro, data) {
            var content = '<div id="iw-container">' +
                '<img height="200px" width="300" src="uploads/images/' + data.image + '">' +
                '<a href="phongtro/' + data.slug + '"><div class="iw-title">' + data.title + '</div></a>' +
                '<p><i class="fas fa-map-marker" style="color:#003352"></i> ' + data.address + '<br>' +
                '<br>Phone. ' + data.phone + '</div>';

            google.maps.event.addListener(phongtro, "click", function(e) {

                infowindow.setContent(content);
                infowindow.open(map, phongtro);
                // alert(data.title);
            });
        })(phongtro, data);

    }
    // google.maps.event.addListener(map, 'mousemove', function (e) {
    // 	document.getElementById("flat").innerHTML = e.latLng.lat().toFixed(6);
    // 	document.getElementById("lng").innerHTML = e.latLng.lng().toFixed(6);

    // });


}
</script>


<script>
var _csrf = '{{csrf_token()}}';
$('#btn-login').click(function(ev) {
    ev.preventDefault();
    var _loginUrl = '{{route("ajax.login")}}';
    var txtuser = $('#txtuser').val();
    var txtpass = $('#txtpass').val();
    $.ajax({
        url: _loginUrl,
        type: 'POST',
        data: {
            txtuser: txtuser,
            txtpass: txtpass,
            _token: _csrf
        },
        success: function(res) {
            if (res.error) {
                let _html_eror =
                    '<div class="alert alert-danger">	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                for (let error of res.error) {
                    _html_eror += `<li>${error}</li>`;
                }
                _html_eror += '</div>';

                $('#error').html(_html_eror);
            } else {
                alert('Đăng nhập thành công.');
                location.reload();
            }
            console.log(res);
        }

    });

});

$('#btn-comment-2').click(function(ev) {
    ev.preventDefault();
    let content = $('#comment-content').val();
    let _commentUrl = '{{route("ajax.commentReview")}}';
    // console.log(content,_commentUrl);
    $.ajax({
        url: _commentUrl,
        type: 'POST',
        data: {
            content: content,
            _token: _csrf
        },
        success: function(res) {
            if (res.error) {
                $('#comment-error').html(res.error);
                console.log(res.error);
            } else {
                $('#comment-error').html('');
                $('#comment-content').val('');
                $('#comment-contentView').html(res);
                location.reload();
                //  console.log(res);
            }
        }

    });


});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDc7PnOq3Hxzq6dxeUVaY8WGLHIePl0swY&callback=initMap" async
    defer></script>

@endsection
<!-- AIzaSyCzlVX517mZWArHv4Dt3_JVG0aPmbSE5mE || AIzaSyAunKgp-ab6Xg8wvcsmOwNMnhxXF33YKcU || -->