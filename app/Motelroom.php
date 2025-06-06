<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;

class Motelroom extends Model

{
    use Sluggable;
    use SluggableScopeHelpers;
    use HasFactory;

    protected $table = "motelrooms";
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
    public function favourite(){
        return $this->belongsToMany(User::class,'savenews','motelrooms_id','user_id');
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
