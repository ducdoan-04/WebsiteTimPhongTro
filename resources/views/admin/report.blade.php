@extends('admin.layout.master')
@section('content2')
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
<!-- Main content -->
<div class="content-wrapper">
	<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
						<h4><a href="/admin" style="color:#000;"><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</a></span> - Danh sách báo cáo từ người dùng</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="admin"><i class="icon-home2 position-left"></i> Trang chủ</a></li>
							<li class="active">Danh sách báo cáo từ người dùng</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
	<div class="content">
		<div class="row">
			<div class="col-12">
				<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Danh sách báo cáo từ người dùng <span class="badge badge-primary">{{ $reports }}</span></h5>
						</div>

						<div class="panel-body">
							Các <code>Báo cáo</code> được liệt kê tại đây. <strong>Dữ liệu đang cập nhật.</strong>
						</div>
                        @if(session('thongbao'))
                        <div class="alert bg-success">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							<span class="text-semibold">Well done!</span>  {{session('thongbao')}}
						</div>
                        @endif
						<table class="table datatable-show-all">
							<thead>
								<tr class="bg-blue">
									<th>IP Address</th>
									<th>Bài đăng</th>
									<th>Trạng thái</th>
									<th class="text-center">Thời gian</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($motels as $room)
									@foreach($room->reports as $report)
									<tr>
										<td>{{$report->ip_address}}</td>
										<td><a href="phongtro/{{$room->slug}}" target="_blank">{{$room->title}}</a></td>
										
										<td>
											@if($report->status == 1)
												<span class="label label-success">Đã cho thuê</span>
											@elseif($report->status == 2)
												<span class="label label-danger">Sai nội dung</span>
											@endif
										</td>
										<td class="text-center">
											{{ time_elapsed_string($report->created_at) }} <span class="badge badge-primary">{{ $report->created_at }}</span>
										</td>
										<td class="text-center">
											<ul class="icons-list">
												<li class="dropdown">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>

													<ul class="dropdown-menu dropdown-menu-right">
														@if($room->approve == 1)
															<li><a href="admin/motelrooms/unapprove/{{$room->id}}"><i class="icon-file-pdf"></i> Bỏ kiểm duyệt</a></li>
														@elseif($room->tinhtrang == 0)
															<li><a href="admin/motelrooms/approve/{{$room->id}}"><i class="icon-file-pdf"></i> Kiểm duyệt</a></li>
														@endif
														<li><a href="phongtro/{{$room->slug}}"><i class="icon-eye"></i>Xem</a></li>
														<li><a href="admin/motelreport/del/{{$report->id}}"><i class="icon-file-excel"></i>Xóa</a></li>
													</ul>
												</li>
											</ul>
										</td>
									</tr>
									@endforeach
								@endforeach

							</tbody>
						</table>
					</div>
			</div>
		</div>
		<!-- Footer -->
		<div class="footer text-muted">
			&copy; 2023. <a href="#">Website tìm kiếm phòng trọ</a> by <a href="" target="_blank">Đoan</a>
		</div>
		<!-- /footer -->
	</div>
</div>
@endsection