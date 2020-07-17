<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Interfaces\CMS\Master\Users\UserInterface',
            'App\Repositories\CMS\Master\Users\UserRepository'
        );
        $this->app->bind(
            'App\Interfaces\CMS\Master\Users\ProfileInterface',
            'App\Repositories\CMS\Master\Users\ProfileRepository'
        );
        $this->app->bind(
            'App\Interfaces\CMS\Master\RoleInterface',
            'App\Repositories\CMS\Master\RoleRepository'
        );
    }
}