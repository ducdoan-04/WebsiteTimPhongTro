<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'address',
        'city',
        'district',
        'area',
        'max_people',
        'is_available'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 