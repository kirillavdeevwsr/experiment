<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-admin', function($user){
            $roles = Role::where('short_name', 'admin')->get();
            return $user->roles->contains('short_name',$roles->first()->short_name);
        });

        Gate::define('is-teacher', function($user){
            $roles = Role::where('short_name', 'teacher')->get();
            return $user->roles->contains('short_name',$roles->first()->short_name);
        });

        Gate::define('is-user', function($user){
            $roles = Role::where('short_name', 'user')->get();
            return $user->roles->contains('short_name',$roles->first()->short_name);
        });

        Gate::define('is-accountant', function($user){
            $roles = Role::where('short_name', 'accountant')->get();
            return $user->roles->contains('short_name',$roles->first()->short_name);
        });

        Gate::define('is-assessment-manager', function($user){
            $roles = Role::where('short_name', 'assessment_manager')->get();
            return $user->roles->contains('short_name',$roles->first()->short_name);
        });

        Gate::define('is-student', function($user){
            $roles = Role::where('short_name', 'student')->get();
            return $user->roles->contains('short_name',$roles->first()->short_name);
        });

    }
}
