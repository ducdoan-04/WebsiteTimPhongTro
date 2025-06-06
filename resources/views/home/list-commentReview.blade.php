@foreach($comments as $comm)
       
            <div class="item slick-slide slick-active" index="<?php echo $comm->id;?>" style="width: 370px;">
          
                <div class="content">
                    <div class="info">
                        <div class="image" style="background-image:  url('uploads/avatars/<?php echo $comm->user->avatar;?>');">
                            <img src="uploads/avatars/<?php echo $comm->user->avatar;?>">
                        </div>
                        <div class="infor-inner">
                            <p class="name">{{$comm->cus->name}}</p>
                            <p class="position"> Đà Nẵng</p>
                        </div>
                    </div>
                    <p class="text-left">{{$comm->content}}</p>
                </div>
            </div>
            <!-- <script src="assets/js/sliderHome.js" async defer></script> -->
@endforeach
