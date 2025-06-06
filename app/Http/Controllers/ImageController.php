<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index()
    {
        return view('home.image-view');
    }

    public function store(Request $request)
    {
        // $imageName = $request->file->getClientOriginalName();
        
        // $imageName ="phongtro-".Str::random(5).rand(1000, 9999)."-".$request->file->getClientOriginalName();
        // $request->file->move(public_path('upload'), $imageName);
        // return response()->json(['uploaded' => '/upload/' . $imageName]);
       
        $json_img ="";
        if ($request->hasFile('file')){
        $arr_images = array();
        $inputfile =  $request->file('file');
        foreach ($inputfile as $filehinh) {
            $namefile = "phongtro-".Str::random(5).rand(1000,9999)."-".$filehinh->getClientOriginalName();
            while (file_exists('/upload/'.$namefile)) {
              $namefile = "phongtro-".Str::random(5).rand(1000,9999)."-".$filehinh->getClientOriginalName();
            }
           $arr_images[] = $namefile;
           $filehinh->move('/upload/',$namefile);
         }
         $json_img =  json_encode($arr_images,JSON_FORCE_OBJECT);
         
            }else {
                $arr_images[] = "no_img_room.png";
                $json_img = json_encode($arr_images,JSON_FORCE_OBJECT);
             }
           
        }
}
