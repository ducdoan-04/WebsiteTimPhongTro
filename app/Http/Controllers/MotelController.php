<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Motelroom;
use App\Categories;
use App\Reports;
use App\District;

class MotelController extends Controller
{
	public function SearchMotelAjax(Request $request){
		$query = Motelroom::where([
			['district_id', $request->id_ditrict],
			['price', '>=', $request->min_price],
			['price', '<=', $request->max_price],
			['category_id', $request->id_category],
			['approve', 1],
		]);
	
		if (!empty($request->min_area)) {
			$query->where('area', '>=', (float)$request->min_area);
		}
	
		if (!empty($request->max_area)) {
			$query->where('area', '<=', (float)$request->max_area);
		}
	
		$getmotel = $query->get();
	
		$arr_result_search = [];
		foreach ($getmotel as $room) {
			$arrlatlng = json_decode($room->latlng, true);
			$arrImg = json_decode($room->images, true);
			$arr_result_search[] = [
				"id" => $room->id,
				"lat" => $arrlatlng[0],
				"lng" => $arrlatlng[1],
				"title" => $room->title,
				"address" => $room->address,
				"image" => $arrImg[0],
				"phone" => $room->phone
			];
		}
	
		return json_encode($arr_result_search);
	}
	
	
	public function SearchMotelAjax2(Request $request){
		$getmotel = Motelroom::where([
			['district_id',$request->id_ditrict],
			['price','>=',$request->min_price],
			['price','<=',$request->max_price],
			['category_id',$request->id_category],
			['area','>=',$request->min_area],
			['area','<=',$request->max_area],
			['approve',1]])->get();
		$arr_result_search = array();
		foreach ($getmotel as $room) {
			$arrlatlng = json_decode($room->latlng,true);
			$arrImg = json_decode($room->images,true);
			$arr_result_search[] = ["id" =>$room->id,"lat"=> $arrlatlng[0],"lng"=> $arrlatlng[1],"title"=>$room->title,"address"=> $room->address,"image"=>$arrImg[0],"phone"=>$room->phone];
		}
		return json_encode($arr_result_search);
	}


	public function SearchMotelAjax1(Request $request){
		$getmotel = Motelroom::where([
			['district_id',$request->id_ditrict],
			['price','>=',$request->min_price],
			['price','<=',$request->max_price],
			['category_id',$request->id_category],
			['approve',1]])->get();
	
		$arr_result_search = array();
	
		foreach ($getmotel as $room) {
			$arrlatlng = json_decode($room->latlng,true);
			$arrImg = json_decode($room->images,true);
			$arr_result_search[] = [
				"id" => $room->id,
				"lat" => $arrlatlng[0],
				"lng" => $arrlatlng[1],
				"title" => $room->title,
				"address" => $room->address,
				"image" => $arrImg[0],
				"phone" => $room->phone
			];
		}
	
		return json_encode($arr_result_search);
	}
	
	

	public function user_del_motel($id){
		if (!Auth::check()) {
			return redirect('user/login');
		}
		else 
		{
			$getmotel = Motelroom::find($id);
			if(Auth::id() != $getmotel->user_id )
				return redirect('user/profile')->with('thongbao','Bạn không có quyền xóa bài đăng không phải là của bạn!');
			else
			{
				$getmotel->delete();
				return redirect('user/profile')->with('thongbao','Đã xóa bài đăng của bạn');
			}
		}
	}

	
	public function getEditmotel($id){
		$userID = Auth::user()->id;
		$getmotel = Motelroom::find($id);

		$district = District::all();
        $categories = Categories::all();
		
		if (!Auth::check()) {
			return redirect('user/login');
		}
		else 
		{
			if(Auth::id() != $getmotel->user_id )
				return redirect('user/quanlytin')->with('thongbao','Bạn không có quyền chỉnh sửa bài đăng không phải là của bạn!');
			else
			{
				$mypost = Motelroom::where('user_id',Auth::user()->id)->get();
				return view('home.edit-motel',[
				   'categories'=>$categories,
				   'mypost'=> $mypost,
				   'district'=>$district,
				   'categories'=>$categories,
				   'motelroom'=>$getmotel
				]);
			}
		}
	}

	public function getMotelByDistrictId($id){
		$getmotel = Motelroom::where([['district_id',$id],['approve',1]])->paginate(3);
		$Categories = Categories::all();
		return view('home.district',['listmotel'=>$getmotel,'categories'=>$Categories]);
	}

	public function getMotelByCategoryId($id){
		$getmotel = Motelroom::where([['category_id',$id],['approve',1]])->paginate(3);
		$Categories = Categories::all();
		return view('home.category',['listmotel'=>$getmotel,'categories'=>$Categories]);
	}
	public function userReport($id,Request $request){
		$ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    $report = new Reports;
	    $report->ip_address = $ipaddress;
	    $report->id_motelroom = $id;
	    $report->status = $request->baocao;
	    $report->save();
	    $getmotel = Motelroom::find($id);
		return redirect('phongtro/'.$getmotel->slug)->with('thongbao','Cảm ơn bạn đã báo cáo, đội ngũ chúng tôi sẽ xem xét');
	}
}
