@extends('admin.layout.master')
@section('content2')
<!-- Main content -->
<div class="content-wrapper">
	<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
						<h4><a href="/admin" style="color:#000;"><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</a></span> - Danh sách thành viên</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="admin"><i class="icon-home2 position-left"></i> Trang chủ</a></li>
							<li class="active">Trang Quản Lý</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
	<div class="content">
		<div class="row">
			<div class="col-12">
				<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Danh sách tài khoản <span class="badge badge-primary">{{$users->count()}}</span></h5>
						</div>

						<div class="panel-body">
							Các <code>Tài khoản</code> được liệt kê tại đây. <strong>Dữ liệu đang cập nhật.</strong>
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
									<th>ID</th>
									<th>Họ Tên</th>
									<th>Avatar</th>
									<th>Email</th>
									<th>Quyền</th>
									<th>Trạng thái</th>
									<th class="text-center">Tùy chọn</th><!--Actions-->
								</tr>
							</thead>
							<tbody>
								@foreach($users as $tk)
								<tr>
									<td>{{$tk->id}}</td>
									
									<td>{{$tk->name}}</td>
									<td>
										<img src="/uploads/avatars/{{$tk->avatar}}"  style="border-radius: 50%;height: 38px;width: 38px;margin-top: -10px; margin-bottom: -10px;" alt="">
									</td>
									<td>{{$tk->email}}</td>
									
									<td>
										@if($tk->right == 1)
											Quản trị viên
										@else
											Người dùng
										@endif
									</td>
									<td>
										@if($tk->tinhtrang == 1)
											<span class="label label-success">Hoạt động</span>
										@elseif($tk->tinhtrang == 2)
											<span class="label label-default">Chờ Phê Duyệt</span>
										@else
											<span class="label label-danger">Tạm Khóa</span>
										@endif
									</td>
									<td class="text-center">
										<ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<ul class="dropdown-menu dropdown-menu-right">
													<li><a href="admin/users/edit/{{$tk->id}}"><i class="icon-file-pdf"></i> Chỉnh sửa</a></li>
													<li><a href="admin/users/del/{{$tk->id}}"><i class="icon-file-excel"></i> Xóa</a></li>
												</ul>
											</li>
										</ul>
									</td>
								</tr>
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