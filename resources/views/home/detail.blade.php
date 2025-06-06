		@extends('layouts.master')
		@section('content')
		<?php 
		function limit_description($string){
			$string = strip_tags($string);
			if (strlen($string) > 150) {

				// truncate string
				$stringCut = substr($string, 0, 150);
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
		<div class="gap"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="breadcrumb">
						<li><a href="#">Trang Chủ</a></li>
						<li><a href="#">{{ $motelroom->category->name }}</a></li>
						<li class="active">{{ $motelroom->title }}</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<!-- <h1 class="entry-title entry-prop">{{ $motelroom->title }}</h1> -->
					<h3 class="title-comm" style="margin-top: 14px;margin-bottom: 6px;"><span class="title-holder">THÔNG TIN CHI TIẾT</span></h3>
					
					<div class="row">
						<div class="col-md-6">
							<!-- <span class="price_area"><span class="price_label">VND</span></span> -->
						</div>
					</div>
					<!-- <h2>VỊ TRÍ</h2> -->
					<div id="map-detail" style="border-top-left-radius: 8px;border-top-right-radius: 8px;"></div>

					<hr>
					<div class="blog-title" style="margin-bottom: 20px;">
						<h2 class="entry-title entry-prop" style="font-weight: 500;font-size: 30px;color: #0045A8;">{{ $motelroom->title }}</h2>
					</div>

						<div class="social-date" style="cursor: pointer;">
							<div class="tag eye"><i class="fas fa-eye"></i> {{ $motelroom->count_view }}</div>
							<a href="{{ route('user.savenews.add',$motelroom->id) }}" class="tag saved heart-20676 add-to-wishlist">Lưu tin</a>
						</div>

					<hr>
			
					<div class="detail info-wrapper">
						<!-- {{ $motelroom->count_view }} -->
						<dl>
							<dt>Địa chỉ:</dt>
							<dd> {{ $motelroom->address }}</dd>
						</dl>
						<dl>
							<dt>Giá phòng:</dt>
							<!-- {{ number_format($motelroom->price) }}  -->
							<dd> <?php echo number_format($motelroom->price); ?>   <span class="price_label">VND</span></dd>
						</dl>
						<div class="info">
							<div class="i-left">

								<dl>
									<dt>Diện tích</dt>
									<dd>{{$motelroom->area}} m <sup>2</sup> </dd>
								</dl>

								<dl>
									<dt>Số phòng</dt>
									<dd>-</dd>
								</dl>
								<dl>
									<dt>Ở tối đa</dt>
									<dd>-</dd>
								</dl>

							</div>

							<div class="i-right">
								
								<dl>
									<dt>Người đăng</dt>
									<dd>
										@if($motelroom->user->avatar == 'no-avatar.jpg')
										<img src="images/no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="33" height="33"> 
										@else
											<img src="uploads/avatars/<?php echo $motelroom->user->avatar; ?>" class="img-circle" alt="Cinque Terre" width="33" height="33"> 
										@endif
										 {{ $motelroom->user->name }}
									</dd>
								</dl>

								<dl>
									<dt>Điện thoại</dt>
									<dd>
										<a id="show_phone_bnt" href="callto:{{ $motelroom->phone }}" style="">	
											{{ $motelroom->phone }}
										</a>
									</dd>
								</dl>
								<dl>
									<dt>Ngày đăng</dt>
									<dd><?php echo time_elapsed_string($motelroom->created_at); ?></dd>
								</dl>

							</div>
						</div>	


					</div>
					
					<div class="content-detail__wrap">
						<h2>Thông tin chi tiết</h2>
						<div class="content-detail">
							<div class="content">
								<p class="pre"><?php echo $motelroom->description ;?></p>
							</div>
						</div>
					</div>
					<hr>
					<div class="box-check">
						<!-- Tiện ích -->
						<?php $arrtienich = json_decode($motelroom->utilities,true); ?>
							<div id="km-detail">
								<div class="fs-dtslt">TIỆN NGHI</div>
								<div style="padding: 5px;">
									@foreach($arrtienich as $tienich)
									<p><i class="fas fa-check"></i> {{ $tienich }}</p> 
									@endforeach
								</div>
							</div>
					</div>
					<div class="box-image">
						<div class="title">
							HÌNH ẢNH CHI TIẾT
						</div>
						
						<div class="container-slide-img">

							<div class="slide-show">
								<div class="list-images">
									<?php 
									$arrimg =  json_decode($motelroom->images,true);
									?>
									<!-- <img src="" alt=""> -->
									@foreach($arrimg as $img)
										<img id="imagess" class="info-images" src="uploads/images/<?php echo $img; ?>"  style="border-radius: 10px;">
										<!-- width="50%" -->
									@endforeach
									
								</div>

								<div class="btns">
									<div class="btn-left btn"><i class="fas fa-chevron-left"></i></div>
									<div class="btn-right btn"><i class="fas fa-chevron-right"></i></div>
								</div>

								<!-- <div class="index-image">
									<div class="index-item index-item-0 active"></div>
									<div class="index-item index-item-1 "></div>
								</div> -->

							</div>

						</div>

					</div>
	
					<div class="gap"></div>
					<!--  -->
					<hr>
					<div class="" id="hostel-detail">
						<!-- ĐÁNH GIÁ -->
						<div class="box-info-review" id="hostel-review">
							<h2 class="title">0 <i class="fa fa-star"></i> (Chưa có đánh giá)</h2>
							<div class="inner-review">
								<ul>
									<li>
										<p class="name">Chủ trọ :</p>
										<div class="grade">
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
										</div>
									</li>
									<li>
										<p class="name">Giá cả :</p>
										<div class="grade">
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
										</div>
									</li>
									<li>
										<p class="name">Môi trường :</p>
										<div class="grade">
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
										</div>
									</li>
									<li>
										<p class="name">Tiện ích :</p>
										<div class="grade">
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
										</div>
									</li>
									<li>
										<p class="name">An ninh :</p>
										<div class="grade">
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
										</div>
									</li>
									<li>
										<p class="name">Hàng xóm :</p>
										<div class="grade">
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
											<span class="fa fa-star "></span>
										</div>
									</li>
								</ul>
							</div>
							<!-- --- -->
							<div class="nav-tabs-custom" style="display:none;">
								<ul class="nav nav-tabs">
									<li class="active">
										<a >Đánh giá</a>
									</li>
									<li class="">
										<a data-toggle="modal" class="port">Viết đánh giá</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<div class="item">
											<div class="content-review">
												<p style="padding: 0 10px">Chưa có đánh giá nào</p>
												<a href="#" class="more-review">Xem thêm<span class="fa fa-angle-right"></span></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--  -->
							<div class="container-comment">
									@if(Auth::user())
									<form action="" method="POST" role="form">
										<legend style="color:#5f5d5d;">Bình luận bài đăng này</legend>
									
										<div class="form-group">
											<label for="">Nội dung bình luận</label>
											<input type="hidden" value="{{$motelroom->id}}"  name="blog-id">
											<textarea id="comment-content" class="form-control" placeholder="Nhập bình luận của bạn..."></textarea>
											<!-- required ="required" -->
											<small id="comment-error" class="help-blog"></small>
										</div>

										<button type="button" class="btn btn-primary" id="btn-comment" >Gửi bình luận</button>
									</form>
									@else
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modelId"> Đăng nhập để bình luận</button>
									@endif
									<br>
										<h3>Các bình luận({{count($motelroom->comments)}})</h3>
									<br>
									<div id="comment" style="overflow-y: scroll; height:250px;">	
										@include('home.list-comment',['comments'=> $motelroom->comments])
									</div>
							</div>
						</div>
						<!-- END ĐÁNH GIÁ -->

					</div>
				</div>
				<div class="col-md-4">
					<div class="contactpanel">
						<div class="row">
							<div class="col-md-4 text-center">
								
							</div>
							<div class="col-md-8">

							</div>
						</div>
					</div>


					
					<div class="gap"></div>
						<div class="box-report">
							@if(session('thongbao'))
							<div class="alert bg-success">
								<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
								<span class="text-semibold">Well done!</span>  {{session('thongbao')}}
							</div>
							@else
							<div class="report">
								<div class="title">BÁO CÁO</div>
								<form action="{{ route('user.report',['id'=> $motelroom->id]) }}" >
									<label class="radio" style="margin-right:15px"> Hết phòng
										<input type="radio" checked="checked" name="baocao" value="1">
										<span class="checkround"></span>
									</label>
									<label class="radio"> Sai thông tin
										<input type="radio" name="baocao" value="2">
										<span class="checkround"></span>
									</label>
									<button class="btn btn-danger">Gửi báo cáo</button>
								</form>
							</div>
							@endif
							<img src="images/banner-1.png" width="100%" style="margin-top: 20px;border-radius: 10px;">
							<img src="images/bg-ads-1.png" width="100%" style="border-radius: 10px; margin-top:42px;">
							<img src="images/bg-ads-2.png" width="100%" style="border-radius: 10px; margin-top:42px;">
						</div>
					<!-- /// -->
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$(document).ready(function() {
				var slider = $('.pgwSlider').pgwSlider();
				slider.previousSlide();
			});
		</script>
<!--  -->
<script>
    var map;
    function initMap() {
        map = L.map('map-detail').setView([16.067011, 108.214388], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        <?php
        $arrlatlng = json_decode($motelroom->latlng, true);
        $lat = $arrlatlng[0];
        $lng = $arrlatlng[1];
        $title = $motelroom->title;
        $address = $motelroom->address;
        $phone = $motelroom->phone;
        $slug = $motelroom->slug;
        ?>

        var phongtro = L.marker([<?= $lat ?>, <?= $lng ?>], { icon: L.icon({ iconUrl: 'images/gps.png', iconSize: [32, 32] }) }).addTo(map);
        var content = '<div id="iw-container">' +
            '<a href="phongtro/<?= $slug ?>"><div class="iw-title"><?= $title ?></div></a>' +
            '<p><i class="fas fa-map-marker" style="color:#ff0000"></i> <?= $address ?><br>' +
            '<br>Phone. <?= $phone ?></div>';

        phongtro.bindPopup(content).openPopup();
    }
</script>





<!-- Gọi hàm initMap khi tải xong trang -->
<script>
	document.addEventListener("DOMContentLoaded", function () {
		initMap();
	});
</script>
<!--  -->

		
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
										<input type="text" class="form-control" size="52" id="txtuser" placeholder="Tài khoản đăng nhập hệ thống">
									</div>
									<div class="form-group">
										<label for="">Mật khẩu</label>
										<input type="password" class="form-control" size="52" id="txtpass" placeholder="Mật khẩu" >
									</div>
								

									<button type="button" class="btn btn-primary btn-block" id="btn-login">Đăng Nhập Ngay</button>
									<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
								</form>
								
							</div>
					
				</div>
			</div>
		</div>
		
		<script>
			$('#exampleModal').on('show.bs.modal', event => {
				var button = $(event.relatedTarget);
				var modal = $(this);
				// Use above variables to manipulate the DOM
				
			});
		</script>
		

		<script>
			var _csrf = '{{csrf_token()}}';
			let _commentUrl = '{{route("ajax.comment",$motelroom->id)}}';
			$('#btn-login').click(function(ev){
				ev.preventDefault();
				var _loginUrl = '{{route("ajax.login")}}';
				var txtuser = $('#txtuser').val();
				var txtpass = $('#txtpass').val();
				$.ajax({
					url:_loginUrl,
					type:'POST',
					data:{
						txtuser: txtuser,
						txtpass: txtpass,
						_token: _csrf
					},
					success:function(res){
						if(res.error){
							let _html_eror = '<div class="alert alert-danger">	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
							for(let error of res.error){
								_html_eror +=`<li>${error}</li>`;
							}
							_html_eror += '</div>';

							$('#error').html(_html_eror);
						}else{
							alert('Đăng nhập thành công.');
							location.reload();
						}
						console.log(res);
					}
					
				});

			});
			$('#btn-comment').click(function(ev){
				ev.preventDefault();
				let content = $('#comment-content').val();
				// let _commentUrl = '{{route("ajax.comment",$motelroom->id)}}';
				console.log(content,_commentUrl);

				$.ajax({
					url:_commentUrl,
					type:'POST',
					data:{
						content: content,
						_token: _csrf
					},
					success:function(res){
						if(res.error){					
							$('#comment-error').html(res.error);
						}else{
							$('#comment-error').html('');
							$('#comment-content').val('');
							$('#comment').html(res);
							// console.log(res);
						}
						
					}
					
				});
			});
			$(document).on('click', '.btn-show-reply-form', function(ev){
				ev.preventDefault();
				var id=$(this).data('id');
				var comment_reply_id = ('#content-reply-')+ id;
				var form_reply = '.form-reply-' + id;
				var contentReply = $(comment_reply_id).val();
				$('.formReply').slideUp();
				$(form_reply).slideDown();
			});
			$(document).on('click', '.btn-send-comment-reply', function(ev){
				ev.preventDefault();
				var id = $(this).data('id');
				var common_reply_id = ('#content-reply-')+ id;
				var contentReply = $(common_reply_id).val();
				var form_reply = '.form-reply-' + id;

				$.ajax({
					url:_commentUrl,
					type:'POST',
					data:{
						content: contentReply,
						reply_id: id,
						_token: _csrf
					},
					success:function(res){
						if(res.error){					
							$('#comment-error').html(res.error);
						}else{
							$('#comment-error').html('');
							$('#comment-content').val('');
							$('#comment').html(res);
							// console.log(res);
						}
						
					}
					
				});

				
			});

		</script>
		<script src="assets/js/slider.js"defer></script>
		@endsection
		
						


		<!-- <script>

			var map;
			function initMap() {
				map = new google.maps.Map(document.getElementById('map-detail'), {
					center: {lat: 16.067011, lng: 108.214388},
					zoom: 15,
					draggable: true
				});
				/* Get latlng vị trí phòng trọ */
				<?php
				//$arrmergeLatln = array();

				//$arrlatlng = json_decode($motelroom->latlng,true);

				//$arrmergeLatln[] = ["lat"=> $arrlatlng[0],"lng"=> $arrlatlng[1],"title"=>$motelroom->title,"address"=> $motelroom->address,"phone"=> $motelroom->phone,"slug"=>$motelroom->slug];
				//$js_array = json_encode($arrmergeLatln);
				//echo "var javascript_array = ". $js_array . ";\n";

				?>
				/* ---------------  */
				
				for (i in javascript_array){
					var data = javascript_array[i];
					var latlng =  new google.maps.LatLng(data.lat,data.lng);
					var phongtro = new google.maps.Marker({
						position:  latlng,
						map: map,
						title: data.title,
						icon: "images/gps.png",
						content: 'dgfdgfdg'
					});
					var infowindow = new google.maps.InfoWindow();
					(function(phongtro, data){
						var content = '<div id="iw-container">' +
						'<a href="phongtro/'+data.slug+'"><div class="iw-title">' + data.title +'</div></a>' +
						'<p><i class="fas fa-map-marker" style="color:#003352"></i> '+ data.address +'<br>'+
						'<br>Phone. ' +data.phone +'</div>';
						infowindow.setContent(content);
						infowindow.open(map, phongtro);
						google.maps.event.addListener(phongtro, "click", function(e){

							infowindow.setContent(content);
							infowindow.open(map, phongtro);
						// alert(data.title);
					});
					})(phongtro,data);

				}
				google.maps.event.addListener(map, 'mousemove', function (e) {
					document.getElementById("flat").innerHTML = e.latLng.lat().toFixed(6);
					document.getElementById("lng").innerHTML = e.latLng.lng().toFixed(6);

				});


			}

		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzlVX517mZWArHv4Dt3_JVG0aPmbSE5mE&callback=initMap"async defer></script>
	 -->