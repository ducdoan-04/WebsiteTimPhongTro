<?php

use App\Http\Controller\AjaxLoginCustomer;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use App\District;
use App\Categories;
use App\Motelroom;
use App\Viewcmt;
Route::get('/', function () {
    $viewcmt = Viewcmt::all();
	$district = District::all();
    $categories = Categories::all();
    $hot_motelroom = Motelroom::where('approve',1)->limit(6)->orderBy('count_view','desc')->get();
    $map_motelroom = Motelroom::where('approve',1)->get();
	$listmotelroom = Motelroom::where('approve',1)->paginate(4);
    return view('home.index',[
        'viewcmt'=>$viewcmt,
    	'district'=>$district,
        'categories'=>$categories,
        'hot_motelroom'=>$hot_motelroom,
    	'map_motelroom'=>$map_motelroom,
        'listmotelroom'=>$listmotelroom
    ]);
});

Route::get('category/{id}','MotelController@getMotelByCategoryId');
Route::get('district/{id}','MotelController@getMotelByDistrictId');
/* Admin */
Route::get('admin/login','AdminController@getLogin');

Route::post('admin/login','AdminController@postLogin')->name('admin.login');
Route::group(['prefix'=>'admin','middleware'=>'adminmiddleware'], function () {
    Route::get('logout','AdminController@logout');
    Route::get('','AdminController@getIndex');
    Route::get('thongke','AdminController@getThongke');
    Route::get('report','AdminController@getReport');
    Route::get('/motelreport/del/{id}','AdminController@DelMotelReport');
   

    Route::group(['prefix'=>'users'],function(){
        Route::get('list','AdminController@getListUser');
        Route::get('edit/{id}','AdminController@getUpdateUser');
        Route::post('edit/{id}','AdminController@postUpdateUser')->name('admin.user.edit');
        Route::get('del/{id}','AdminController@DeleteUser');
    });

    Route::group(['prefix'=>'motelrooms'],function(){
        Route::get('list','AdminController@getListMotel');
        Route::get('approve/{id}','AdminController@ApproveMotelroom');
        Route::get('unapprove/{id}','AdminController@UnApproveMotelroom');
        Route::get('del/{id}','AdminController@DelMotelroom');
        // Route::get('edit/{id}','AdminController@getUpdateUser');
        // Route::post('edit/{id}','AdminController@postUpdateUser')->name('admin.user.edit');
        // Route::get('del/{id}','AdminController@DeleteUser');
    });
});
/* End Admin */
Route::get('/phongtro/{slug}',function($slug){
    $room = Motelroom::findBySlug($slug);
    $room->count_view = $room->count_view +1;
    $room->save();
    $categories = Categories::all();
    
    return view('home.detail',['motelroom'=>$room, 'categories'=>$categories]);
});
Route::get('/report/{id}','MotelController@userReport')->name('user.report');
Route::get('/motelroom/del/{id}','MotelController@user_del_motel');
/* User */

Route::post('/search','UserController@getSearch')->name('search');
Route::post('/image-submit', 'UserController@uploadFile')->name('image.submit');
Route::get('image-view','ImageController@index');
Route::group(['prefix'=>'user'], function () {
    
    Route::get('image-view','ImageController@index');

    Route::get('file','UserController@file')->name('user.file');

    Route::get('register','UserController@get_register');
    Route::post('register','UserController@post_register')->name('user.register');

    Route::get('login','UserController@get_login');
    Route::post('login','UserController@post_login')->name('user.login');
    Route::get('logout','UserController@logout');

    Route::get('dangtin','UserController@get_dangtin')->middleware('dangtinmiddleware');
    Route::post('dangtin','UserController@post_dangtin')->name('user.dangtin')->middleware('dangtinmiddleware');

    Route::get('profile','UserController@getprofile')->middleware('dangtinmiddleware');
    Route::get('savenews','UserController@getsavenews');

    Route::get('huongdan','UserController@getHuongdan');
    Route::get('quanlytin','UserController@getQuanlytin');

    Route::get('/motelEdit/{id}','MotelController@getEditmotel');

    Route::get('profile/edit','UserController@getEditprofile')->middleware('dangtinmiddleware');
    Route::post('profile/edit','UserController@postEditprofile')->name('user.edit')->middleware('dangtinmiddleware');
    Route::group(['prefix'=>'savenews'], function () {
        Route::get('/add/{id}','UserController@addSavenews')->name('user.savenews.add');
        Route::get('/del/{id}','UserController@deleteFavorite')->name('user.savenews.del');
    });
});
/* ----*/

Route::post('searchmotel','MotelController@SearchMotelAjax');

// ----Login ajax----
/* User */
Route::group(['prefix'=>'ajax'], function () {
    // Route::get('login','UserController@get_login');
        Route::post('login','AjaxLoginCustomer@login')->name('ajax.login');
        Route::post('comment/{blog_id}','AjaxLoginCustomer@comment')->name('ajax.comment');

        Route::post('commentReview','AjaxLoginCustomer@commentReview')->name('ajax.commentReview');
        Route::get('logout','AjaxLoginCustomer@logout');

});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/room/{room}', [HomeController::class, 'show'])->name('room.show');
Route::get('/search', [HomeController::class, 'search'])->name('room.search');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/my-rooms', [HomeController::class, 'myRooms'])->name('my.rooms');
    Route::get('/room/create', [HomeController::class, 'create'])->name('room.create');
    Route::post('/room', [HomeController::class, 'store'])->name('room.store');
    Route::get('/room/{room}/edit', [HomeController::class, 'edit'])->name('room.edit');
    Route::put('/room/{room}', [HomeController::class, 'update'])->name('room.update');
    Route::delete('/room/{room}', [HomeController::class, 'destroy'])->name('room.destroy');
});

