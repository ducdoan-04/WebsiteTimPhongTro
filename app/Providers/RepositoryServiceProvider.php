<?php

namespace App\Providers;

use App\Interfaces\RoomRepositoryInterface;
use App\Repositories\RoomRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
    }

    public function boot()
    {
        //
    }
} 