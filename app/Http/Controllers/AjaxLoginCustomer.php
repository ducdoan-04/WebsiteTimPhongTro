<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\District;
use App\Categories;
use App\Motelroom;
use App\Models\Comment;
use App\Models\CommentReview;

use Validator;
use Mail;
use Auth;
use Exception;

class AjaxLoginCustomer extends Controller
{

    public function login(Request $req){
        $validator = Validator::make($req->all(),[
            'txtuser' => 'required',
            'txtpass' => 'required'
        ],[
            'txtuser.required' => 'Vui lòng nhập tài khoản',
            'txtpass.required' => 'Vui lòng nhập mật khẩu'
          
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    
        try {
            if(Auth::attempt(['username' => $req->txtuser, 'password' => $req->txtpass])){
                return redirect('/');
            } else {
                return response()->json(['error' => ['Tài khoản hoặc mật khẩu không đúng']]);    
            }
        } catch (Exception $e) {
            return response()->json(['error' => ['Đã xảy ra lỗi trong quá trình đăng nhập']]);
        }
    }

    public function comment ($blog_id,Request $req){
        $user_id = Auth::user()->id;
        $validator = Validator::make($req->all(),[
            'content' => 'required'
        ],[
            'content.required' => 'Vui lòng nhập nội dung bình luận'  
        ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()->first()]);
            }
            else{
                $data=[
                    'user_id' => $user_id,
                    'blog_id' => $blog_id,
                    'content' => $req -> content,
                    'reply_id'=> $req->reply_id ? $req ->reply_id : 0
                ];
                try {
                    if($comment = Comment::create($data)){
                        $comments = Comment::where(['blog_id' => $blog_id,'reply_id' => 0])->orderBy('id','DESC')->get();
                        //return response()->json(['comments'=>$comments]);
                        
                         return view('home.list-comment',compact('comments'));
                    }
                    
                } catch (Exception $e) {
                    return response()->json(['error' => ['Đã xảy ra lỗi trong quá comment']]);
                }
        }
            
    }
    public function commentReview (Request $req){
        $user_id = Auth::user()->id;
        $validator = Validator::make($req->all(),[
            'content' => 'required'
        ],[
            'content.required' => 'Vui lòng nhập nội dung bình luận'  
        ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()->first()]);
            }
            else{
                $data=[
                    'user_id' => $user_id,
                    'content' => $req -> content
                ];
                try {
                    if($comment = CommentReview::create($data)){
                        $comments = CommentReview::where(['reply_id'=> 0])->orderBy('id','ASC')->get();
                        // return response()->json(['comments'=>$comments]);
                        return view('home.list-commentReview',compact('comments'));
                    }
                    
                } catch (Exception $e) {
                    return response()->json(['error' => ['Đã xảy ra lỗi trong quá comment']]);
                }
        }
            
    }

}
    
