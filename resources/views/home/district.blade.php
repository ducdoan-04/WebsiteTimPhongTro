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

	<div class="container-fluid" style="padding-left: 0px;padding-right: 0px;">



	</div>
	<div class="container" style="min-height: 400px; margin-top:50px;">
		@if(count($listmotel) > 0)
		<?php $firstDistrict = $listmotel[0]->district; ?>
			<h3 class="title-comm"><span class="title-holder" style="text-transform: uppercase;">KẾT QUẢ TÌM KIẾM THEO QUẬN {{ $firstDistrict->name }} ({{ count($listmotel) }})</span></h3>
		@else
		<h3 class="title-comm"><span class="title-holder" style="text-transform: uppercase;">KẾT QUẢ TÌM KIẾM THEO QUẬN (<?php echo count($listmotel); ?>)</span></h3>
		@endif
		
		@if(count($listmotel) == 0)
			Không có kết quả nào trong danh mục này
		@endif
		<div class="row room-hot right" id="center">
			<div class="hostel hostel-list main-list">
				@foreach($listmotel as $room)
				<?php 
				$img_thumb = json_decode($room->images,true);
				?>

			
				<div class="col-md-4 col-sm-6" id="category">
					<div class="room-item boder">
						<div class="image">
							<div class="wrap-img" style="background: url(uploads/images/<?php echo $img_thumb[0]; ?>) center;     background-size: cover;">
								<img src="" class="lazyload img-responsive">
							</div>
						</div>
						<div class="room-detail info">
								<div class="category star">
									<span class="local">
										<a href="">{{ $room->category->name }}</a>
									</span>
									<span class="pull-right"><i class="fas fa-eye"></i> Lượt xem: <b>{{ $room->count_view }}</b></span>
								</div>

							<h4 class="title-category layout-1"><a href="phongtro/{{ $room->slug }}">{{ $room->title }}</a></h4>
							
							<div class="room-meta">
								<span><i class="fas fa-user-circle"></i> Người đăng: <a href="/"> {{ $room->user->name }}</a></span>
								<span><i class="far fa-stop-circle"></i> Diện tích: <b>{{ $room->area }} m<sup>2</sup></b></span>
							</div>

							<div class="room-description" style="text-align: left;">
								<i class="fas fa-audio-description"></i>
								{{ limit_description($room->description) }}
							</div>
							<div class="location-area">
										<dl class="address">
											<dt><i class="fas fa-map-marker"></i> Địa chỉ: {{ $room->address }}</dt>
										</dl>
							</div>	
							<div class="room-info">
								<div style="color: #e74c3c">
									<div class="price" style="float: left !important;">
										<i class="far fa-money-bill-alt"></i> 
										<b>{{ number_format($room->price) }} VNĐ</b>
									</div>
									<span class="pull-right"><i class="far fa-clock"></i>
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

			<!--  -->
			@if(count($listmotel) != 0)
			<ul class="pagination pull-right" style="display: flex;justify-content: center;float: none !important;">
				@if($listmotel->currentPage() != 1)
				<li><a href="{{ $listmotel->url($listmotel->currentPage() -1) }}">Trước</a></li>
				@endif
				@for($i= 1 ; $i<= $listmotel->lastPage(); $i++)
				<li class=" {{ ($listmotel->currentPage() == $i )? 'active':''}}">
					<a href="{{ $listmotel->url($i) }}">{{ $i }}</a>
				</li>
				@endfor
				@if($listmotel->currentPage() != $listmotel->lastPage())
				<li><a href="{{ $listmotel->url($listmotel->currentPage() +1) }}">Sau</a></li>
				@endif
			</ul>
			@endif
</div>
@endsection