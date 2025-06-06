<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
} 