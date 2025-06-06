@foreach($comments as $comm)

<div class="media media-check-cmt" id="media-check-cmt-{{$comm->reply_id}}">
    <a class="pull-left mr-2" href="#">
    <img class="media-object" src="uploads/avatars/<?php echo $comm->cus->avatar;?>" width="50" alt="Image" style="border-radius:50%;">
    </a>
    <div class="media-body">
            <h4 class="media-heading">{{$comm->cus->name}} - <a style="font-size:12px;">{{ time_elapsed_string($comm->created_at) }}</a></h4>
            <p>{{$comm->content}}</p>
            <p>@if(Auth::user())
                <a href="" class="btn btn-sm btn-primary btn-show-reply-form" data-id="{{$comm->id}}" style="color:#fff;">Trả lời</a>
                @else
                    <button type="button" class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#modelId"> Đăng nhập để bình luận</button>
                    @endif
            </p>
            <form action="" method="POST"  style="display:none" class="formReply form-reply-{{$comm->id}}">
                
                <div class="form-group">
                    <label for="">Nội dung bình luận</label>
                    <textarea  id="content-reply-{{$comm->id}}" class="form-control" 
                        placeholder="Nhập bình luận của bạn..."></textarea>
                    <!-- required ="required" -->
                    <!-- <small id="comment-error" class="help-blog"></small> -->
                </div>

                <button type="submit" class="btn btn-primary btn-send-comment-reply"  data-id="{{$comm->id}}" >Trả lời bình luận</button>
            </form>
            <!-- các bình luận con -->
          
            @foreach($comm ->replies as $child)
            <div class="media">
                <a class="pull-left mr-2" href="#">
                  <img class="media-object" src="uploads/avatars/<?php echo $child->cus->avatar;?>" width="50" alt="Image" style="border-radius:50%;">
                </a>
                <div class="media-body">
                        <h4 class="media-heading">{{$child->cus->name}} - <a style="font-size:12px;">{{ time_elapsed_string($comm->created_at) }}</a></h4>
                        <p>{{$child->content}}</p>     
                        <p><a href="" class="btn btn-sm btn-primary btn-show-reply-form" data-id="{{$child->id}}" style="color:#fff;">Trả lời</a></p>
                        <form action="" method="POST"  style="display:none" class="formReply form-reply-{{$child->id}}">
                            <div class="form-group">
                                <label for="">Nội dung bình luận</label>
                                <textarea  id="content-reply-{{$child->id}}" class="form-control" placeholder="Nhập bình luận của bạn..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-send-comment-reply"  data-id="{{$child->id}}" >Trả lời bình luận</button>
                        </form>
                            @foreach($child ->replies as $child1)
                            <div class="media">
                                <a class="pull-left mr-2" href="#">
                                <img class="media-object" src="uploads/avatars/<?php echo $child1->cus->avatar;?>" width="50" alt="Image" style="border-radius:50%;">
                                </a>
                                <div class="media-body">
                                        <h4 class="media-heading">{{$child1->cus->name}} - <a style="font-size:12px;">{{ time_elapsed_string($comm->created_at) }}</a></h4>
                                        <p>{{$child1->content}}</p>     
                                </div>
                            </div>
                            @endforeach
                </div>
            </div>
            @endforeach

    </div>
</div>

@endforeach

<script type="text/javascript">
    // var replyId = {{$comm->reply_id}};
    // var mediaElement = document.getElementById('media-check-cmt-' + replyId);
   
    // if (replyId !== 0) {
    //     mediaElement.style.display = 'none';
    // }
    // console.log(replyId);
    // Assuming replyId is the variable you want to check
var replyId = 0;
var elements = document.getElementsByClassName('media-check-cmt');

for (var i = 0; i < elements.length; i++) {
    var currentId = elements[i].id.split('-')[3]; 

    if (currentId != replyId) {
        elements[i].style.display = 'none';
    }
}

// console.log(replyId);    

</script>
										