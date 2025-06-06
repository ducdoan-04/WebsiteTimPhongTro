@extends('layouts.master')
@section('content')

<div class="container" style="padding-left: 0px;padding-right: 0px;display: flex;justify-content: center;padding-top: 100px; ">
	<div class="gap"></div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2" id="form-login-1" style="margin-bottom: 50px">
			<div class="gap"></div>
			<div class="panel panel-primary">
				<!-- <div class="panel-heading">Đăng nhập</div> -->
				<h1 class="login-form-heading">Đăng nhập</h1>
				<div class="panel-body">
					<div class="gap"></div>
					@if ($errors->any())
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					@if(session('warn'))
		                        <div class="alert bg-danger">
									<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
									<span class="text-semibold">Error!</span>  {{session('warn')}}
								</div>
		            @endif
					<form class="form-horizontal" method="POST" action="{{ route('user.login') }}" >
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<!-- <label class="control-label col-sm-3">Tài khoản:</label> -->
							<!-- <div class="col-sm-9">
								<input type="text" class="form-control" name="txtuser" placeholder="Tài khoản đăng nhập hệ thống">
							</div> -->
							<div class="login-form-group">
								<input type="text" class="login-form-input" size="52" placeholder="Tài khoản đăng nhập hệ thống" name="txtuser">
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-sm-3" for="pwd">Mật khẩu:</label>
							<div class="col-sm-9"> 
								<input type="password" class="form-control" name="txtpass" placeholder="Nhập mật khẩu">
							</div> -->
							<div class="login-form-group">
								<input type="password" class="login-form-input" size="52" placeholder="Mật khẩu" name="txtpass">
							</div>
						</div>
						<div  class="form-group"> 
						<!-- class="form-group" -->
							<div class="col-sm-offset-5 col-sm-9">
								<button type="submit" class="btn btn-primary login">Đăng Nhập Ngay</button>
							</div>
						</div>
					</form><div class="gap"></div>
				</div>

				<div class="divider"><span>hoặc &emsp;</span></div>
				<div>
                    <a href="../user/register" class=""><input type="button" value="Tạo tài khoản mới" class="register-new-submit"></a>
                </div>
				<div class="linkLine"><a id="forget_password" href="#" class="sec">Quên mật khẩu?</a></div>
				<div class="or-sign-up"><a>Hoặc đăng nhập với</a></div>
				<div class="btn-item item-sign-up">
                    <li class="social">
                        <a href="https://www.facebook.com/" target="_blank">
                            <img src="https://id.ohi.vn/frontend/home/images/icons/icon_facebook.svg" alt="Facebook" data-pagespeed-url-hash="1352054977">
                        </a>

                        <a href="https://www.google.com/" target="_blank">
                            <img src="https://id.ohi.vn/frontend/home/images/icons/icon_google.svg" style="border-radius: 48%;" alt="Google" data-pagespeed-url-hash="152980296">
                        </a>
                    </li>
                </div>

			<div class="gap"></div>
			</div>
		</div>
	</div>

</div>
@endsection