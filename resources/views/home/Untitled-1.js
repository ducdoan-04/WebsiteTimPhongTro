					< script >

					    var map;

					function initMap() {
					    map = new google.maps.Map(document.getElementById('map'), {
					        center: { lat: 16.070372, lng: 108.214388 },
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

					<
					/script>