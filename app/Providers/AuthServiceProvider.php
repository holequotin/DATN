<?php

namespace App\Providers;

use App\Policies\SchedulePolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Schedule::class => SchedulePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-assign-movie',function($user){
            return $user->role->name == 'Admin' || $user->role->name == 'Manager';
        });
        Gate::define('view-cinema-order',function($user){
            return $user->role->name == 'Manager';
        });
        //
    }
}
