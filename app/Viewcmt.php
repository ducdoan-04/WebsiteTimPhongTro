<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Motelroom;
use App\Reports;
use App\Savenews;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use app\Models\CommentReview;

class Viewcmt extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $table = "commentreview";
    protected $fillable = ['user_id','reply_id', 'content'];

    public function cus(){
    	// return $this->hasOne(User::class,'id','user_id');
        return $this->hasOne('App\User','id','user_id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function views(){
    	// return $this->hasOne(User::class,'id','user_id');
        return $this->hasOne('App\CommentReview','id','user_id');
    }
    public function replies(){
        return $this->hasMany('App\Models\CommentReview','reply_id','id');
    	// return $this->hasMany(comment::class,'reply_id','id');
        // return $this->hasMany('App\Models\Comment','id_motelroom','id')->orderBy('id','DESC');
    }

    public function comments(){
        return $this->hasMany('App\Models\Viewcmt','id')->orderBy('id','ASC');
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
