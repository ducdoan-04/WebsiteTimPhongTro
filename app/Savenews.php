<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Motelroom;
use App\Reports;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use app\Models\CommentReview;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Savenews extends Model

{
    use Sluggable;
    use SluggableScopeHelpers;
    use HasFactory;

    protected $table = "savenews";
    protected $fillable = ['motelrooms_id','user_id'];

    public function category(){
    	return $this->belongsTo('App\Categories','category_id','id');
    }
    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
    public function district(){
    	return $this->belongsTo('App\District','district_id','id');
    }
    public function reports(){
        return $this->hasMany('App\Reports','id_motelroom','id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment','blog_id','id')->orderBy('id','DESC');
    }

   
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
