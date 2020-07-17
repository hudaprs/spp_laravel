<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Only High Admin
        Gate::define('is_high_admin', function($user) {
            return $user->role->name === 'High Admin';
        });

        // Check for the role for guest, but High Admin can pass
        Gate::define('is_correct_user', function($user, $otherUser) {
            if($user->id !== $otherUser->id && $user->role->name === 'High Admin') return true;
            if($user->id === $otherUser->id) return true;
        });
    }
}
