@extends('layouts.master')
@section('content')
<?php 
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

<div class="container" style="top: 60px;margin-bottom: 80px;">
	<div class="row">
		<div class="col-12">

			<div class="mypage">
				<!-- <h4>Tin đã đăng gần đây</h4> -->
				<h3 class="title-comm"><span class="title-holder">Tin đã đăng gần đây</span></h3>
				@if(session('thongbao'))
				<div class="alert bg-danger">
					<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
					<span class="text-semibold">Hi!</span>  {{session('thongbao')}}
				</div>
				@endif
				<div class="mainpage">
					@if( count($mypost) < 1)
					<div class="alert alert-info">
						Bạn chưa có tin đăng phòng trọ nào đang cho thuê, thử đăng ngay.
					</div>
					<a href="user/dangtin" class="btn-post">ĐĂNG TIN</a>
					@else
					<div class="table-responsive">
						<table class="table">
						<thead>
							<tr>
								<th>Tiêu đề</th>
								<th>Danh mục</th>
								<th>Giá phòng</th>
								<th>Lượt xem</th>
								<th>Tình trạng</th>
								<th> </th>
							</tr>
						</thead>
						<tbody>
							@foreach($mypost as $post)
							<tr>	
								<td>{{ $post->title }}</td>
								<td>{{ $post->category->name }}</td>
								<td>{{ $post->price }}</td>
								<td>{{ $post->count_view }}</td>
								<td>
									@if($post->approve == 1)
										<span class="label label-success">Đã kiểm duyệt</span>
									@elseif($post->approve == 0)
										<span class="label label-danger">Chờ Phê Duyệt</span>
									@endif
								</td>
								<td>
									<a href="phongtro/{{ $post->slug }}" style="color: #05132f;"><i class="fas fa-eye"></i> Xem</a>
                                    <a href="user/motelEdit/{{ $post->id }}"><i class="fas fa-edit"></i>Sửa</a>
									<a href="motelroom/del/{{ $post->id }}" style="color:red"><i class="fas fa-trash-alt"></i> Xóa</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					</div>
					@endif
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection