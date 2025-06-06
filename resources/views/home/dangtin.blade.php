
@extends('layouts.master')
@section('content')
<div class="gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<h1 class="entry-title entry-prop" style="font-size:25px; font-weigth:500 !important;" >Đăng tin mới</h1>
      <p class="description">Đăng tin cho thuê phòng của bạn</p>
			<hr>
      <div class="info info-user">
          <div class="contactpanel">
            <div class="row">
              <div class="col-md-4 text-center">
              <!-- <img src="assets/images/noavt.png" class="img-circle" alt="Cinque Terre" width="100" height="100">  -->
                  @if(Auth::user()->avatar == 'no-avatar.jpg')
                  <img style="color:#ffffff;background-color:rgb(188, 188, 188);user-select:none;display:inline-flex;align-items:center;justify-content:center;font-size:40px;border-radius:50%;height:99px;width:99px;" alt="Đức Đoan" size="80" src="images/no-avatar.jpg" class="img-circle" data-reactid="57">
                  @else
                  <img style="color:#ffffff;background-color:rgb(188, 188, 188);user-select:none;display:inline-flex;align-items:center;justify-content:center;font-size:40px;border-radius:50%;height:99px;width:99px;" alt="Đức Đoan" size="80" src="uploads/avatars/{{Auth::user()->avatar}}" class="img-circle" data-reactid="57">
                  @endif
              </div>
              <div class="col-md-8">
                <h4>Thông tin người đăng: <span style="font-weight:300; color: #3298ff;"> {{ Auth::user()->name }}</span></h4>
                <!-- <strong> </strong><br> -->
                <i class="far fa-clock"></i> Ngày tham gia: {{ Auth::user()->created_at }}	
              </div>
            </div>
        </div>
      </div>
			<div class="panel panel-default">
				<div class="panel-heading">Thông tin bắt buộc <span style="color:red;";>*</span></div>
				<div class="panel-body">
					<div class="gap"></div>
					@if ($errors->any())
					<div class="alert   -danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div
					@endif
					@if(session('warn'))
          <div class="alert bg-danger">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            <span class="text-semibold">Error!</span>  {{session('warn')}}
          </div>
          @endif
          @if(session('success'))
					<div class="alert bg-success">
						<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
						<span class="text-semibold">Done!</span>  {{session('success')}}
					</div>
					@endif
          @if(Auth::user()->tinhtrang != 0)
					<form action="{{ route ('user.dangtin') }}" method="POST" enctype="multipart/form-data" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label for="usr">Tiêu đề bài đăng:</label>
							<input type="text" class="form-control" name="txttitle">
						</div>
						<div class="form-group">
							<label>Địa chỉ phòng trọ:</label> Bạn có thể nhập hoặc chọn ví trí trên bản đồ 
							<input type="text" id="location-text-box" name="txtaddress" class="form-control" value="" readonly />

              <p><i class="far fa-bell"></i> Nếu địa chỉ hiển thị bên bản đồ không đúng bạn có thể điều chỉnh bằng cách kéo điểm màu xanh trên bản đồ tới vị trí chính xác.</p>
              <input type="hidden" id="txtaddress" name="txtaddress" value=""  class="form-control"  />
              <input type="hidden" id="txtlat" value="" name="txtlat"  class="form-control"  />
              <input type="hidden" id="txtlng"  value="" name="txtlng" class="form-control" />
            </div>
            <!-- ================ -->
            <div id="map-canvas" style="width: auto; height: 400px;"></div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usr">Giá phòng( vnđ ):</label>
                  <input type="number" name="txtprice" class="form-control" placeholder="750000" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usr">Diện tích( m<sup>2</sup> ):</label>
                  <input type="number" name="txtarea" class="form-control" placeholder="16">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"  >
                <div class="form-group">
                  <label for="usr">Quận/ Huyện:</label>
                  <select class="selectpicker pull-right" data-live-search="true" name="iddistrict">
                    @foreach($district as $quan)
                    <option data-tokens="{{$quan->slug}}" value="{{ $quan->id }}">{{ $quan->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4"  >
                <div class="form-group">
                  <label for="usr">Danh mục:</label>
                  <select class="selectpicker pull-right" data-live-search="true" class="form-control" name="idcategory"> 
                    @foreach($categories as $category)
                    <option data-tokens="{{$category->slug}}" value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4"  >
                <div class="form-group">
                  <label for="usr">SĐT Liên hệ:</label>
                  <input type="text" name="txtphone" class="form-control" placeholder="0919261712">
                </div>
              </div>
            </div> 
            <div class="form-group">
              <!-- ************** Item tiện ích ************** -->
              <label>Các tiện ích có trong phòng trọ:</label>
              <select id="select-state" name="tienich[]" multiple class="demo-default" placeholder="Chọn các tiện ích phòng trọ">
                <option value="Chung chủ" >Chung chủ</option>
                <option value="Không chung chủ">Không chung chủ</option>
                <option value="Wifi free">Wifi free</option>
                <option value="Gác lửng">Gác lửng</option>
                <option value="Vệ sinh riêng">Vệ sinh riêng</option>
                <option value="Vệ sinh chung">Vệ sinh chung</option>
                <option value="Bình nóng lạnh">Bình nóng lạnh</option>
                <option value="Kệ bếp">Kệ bếp</option>
                <option value="Máy giặt">Máy giặt</option>
                <option value="Tivi">Tivi</option>
                <option value="Điều hòa">Điều hòa</option>
                <option value="Tủ lạnh">Tủ lạnh</option>
                <option value="Ban công/sân thượng">Ban công/sân thượng</option>
                <option value="Tủ + giường">Tủ + giường</option>
                <option value="Thang máy">Thang máy</option>
                <option value="Bãi để xe riêng">Bãi để xe riêng</option>
                <option value="Camera an ninh">Camera an ninh</option>
                <option value="Giờ giấc tự do">Giờ giấc tự do</option>
           
            </div>
            <div class="form-group">
                    <!-- <label for="comment" style="top:10px;">Mô tả ngắn:</label> -->
                    <!-- ************** MÔ TẢ NGẮN ************** -->
                    <label for="comment" style="top:10px; ">Mô tả ngắn</label>
                    <div>
                    <textarea class="form-control" id="content" rows="5" name="txtdescription" style="resize: none;" placeholder="Mô tả rõ thêm các thông tin khác."></textarea>
                    </div>
                    <script>
                      ClassicEditor
                          .create( document.querySelector( '#content' ) )
                          .catch( error => {
                              console.error( error );
                          } );
                    </script>
                    

             
            </div>



            <div class="form-group img-upload">
              <label for="comment">Hình ảnh</label>
              <div class="file-loading">
                <!-- <input id="file-5" type="file" class="file" name="hinhanh[]" multiple data-preview-file-type="any" data-upload-url="#" > -->
                <!-- <input type="file" id="file-5" name="file" class="file[]" multiple data-overwrite-initial="false" data-min-file-count="2"> -->
                <input type="file" id="file-5" name="file" class="file" multiple data-overwrite-initial="false" data-preview-file-type="any" data-min-file-count="2" >
              </div>
            </div>
            
            <div class="form-group"  style="display:flex;justify-content: center;">
               <button class="btn btn-primary" style=" padding:10px 10px;">Đăng ngay</button>
            </div>
           
          </form>
          @else
          <div class="alert bg-danger">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            <span class="text-semibold">Error!</span>  Tài khoản của bạn đang bị khóa đăng tin.
          </div>
          @endif
        </div>
      </div>
      <div class="col-md-4" style="margin-top: 12%;">
        <div class="contactpanel">
          <!-- <div class="row">
            <div class="col-md-4 text-center">
            <img src="assets/images/noavt.png" class="img-circle" alt="Cinque Terre" width="100" height="100"> 
            </div>
            <div class="col-md-8">
              <h4>Thông tin người đăng</h4>
              <strong> {{ Auth::user()->name }}</strong><br>
              <i class="far fa-clock"></i> Ngày tham gia: {{ Auth::user()->created_at }}	
            </div>
          </div> -->
          <!-- <img src="images/banner-1.png" width="100%" style="border-radius: 10px;" > -->
          <img src="images/bg-ads-1.png" width="100%" style="border-radius: 10px; ">
          <!-- <img src="images/bg-ads-2.png" width="100%" style="border-radius: 10px; margin-top:42px;"> -->
        </div>
        <!--  -->
        <div class="gap"></div>
    </div>
      	
</div>
</div>
</div>

<!-- -------------------------- -->

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/themes/fa5/theme.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/LANG.js"></script>    -->

<!-- ============= -->
<script type="text/javascript">
    $('#file-5').fileinput({
        theme: 'fa',
        uploadUrl: '{{ route("image.submit") }}', 
        uploadExtraData: function () {
            return {
                _token: $("input[name='_token']").val()
            };
        },
        
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        overwriteInitial: false,
        maxFileSize: 2000,
        maxFileNum: 8,
        slugCallback: function (filename) {
          
            return filename.replace('(', '_').replace(']', '_');
        }
    });

</script>



<!-- Thư viện jQuery -->

<!-- <script type="text/javascript">
   $('#file-5').fileinput({
       theme: 'fa',
       language: 'vi',
       uploadUrl: '{{ route("user.dangtin") }}', 
       showUpload: false,
       allowedFileExtensions: ['jpg', 'png', 'gif']
   });
</script> -->

<!-- Sửa mã JavaScript -->

<script>
  var map;
  var marker;
  function initialize() {
    map = L.map("map-canvas").setView([16.070372, 108.214388], 12);

    // OpenStreetMap tiles
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "© OpenStreetMap contributors",
    }).addTo(map);

    // Get GEOLOCATION
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        function (position) {
          var pos = [position.coords.latitude, position.coords.longitude];
          map.setView(pos, 17);
          marker = L.marker(pos, { draggable: true }).addTo(map);
          updateLocationInfo(marker);

          // Dragend Marker
          marker.on("dragend", function () {
            updateLocationInfo(marker);
          });
        },
        function () {
          handleNoGeolocation(true);
        }
      );
    } else {
      // Browser doesn't support Geolocation
      handleNoGeolocation(false);
    }

    function handleNoGeolocation(errorFlag) {
      if (errorFlag) {
        var content = "Error: The Geolocation service failed.";
      } else {
        var content = "Error: Your browser doesn't support geolocation.";
      }

      var options = {
        map: map,
        zoom: 19,
        position: new L.LatLng(16.070372, 108.214388),
        content: content,
      };

      map.setView(options.position);
      marker = L.marker(options.position, {
        draggable: true,
        icon: L.icon({
          iconUrl: "images/gps.png",
          iconSize: [32, 32],
        }),
      }).addTo(map);

      // Dragend Marker
      marker.on("dragend", function () {
        updateLocationInfo(marker);
      });
    }

    // Leaflet Search Control
    var searchControl = L.Control.geocoder().addTo(map);

    searchControl.on("markgeocode", function (e) {
      var latlng = e.geocode.center;
      map.setView(latlng, 17);
      marker.setLatLng(latlng);
      updateLocationInfo(marker);
    });
  }

  function updateLocationInfo(marker) {
    var latlng = marker.getLatLng();
    var geocoder = L.Control.Geocoder.nominatim();

    geocoder.reverse(latlng, map.options.crs.scale(map.getZoom()), function (
      results
    ) {
      var address = results[0].name;
      document.getElementById("location-text-box").value = address;
      document.getElementById("txtaddress").value = address;
      document.getElementById("txtlat").value = latlng.lat;
      document.getElementById("txtlng").value = latlng.lng;
    });
  }

  initialize();
</script>


<!--  -->
<script type="text/javascript" src="assets/js/selectize.js" ></script>
<script>
$(function() {
    $('select').selectize(options);
  });
  $('#select-state').selectize({
    maxItems: null
  });
</script>
@endsection

