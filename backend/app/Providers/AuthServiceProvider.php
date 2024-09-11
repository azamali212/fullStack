<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Dcotor;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       // Define Gate for Super Admin
       Gate::define('super-admin-access', function (User $user) {
        return $user->hasRole('super-admin', 'super-admin-api');
    });

    // Hospital Admin Gate
    Gate::define('hospital-admin-access', function (User $user) {
        return $user->hasRole('hospital-admin', 'hospital-admin-api');
    });

    // Doctor Admin Gate (Using User model)
    Gate::define('doctor-admin-access', function (User $user) {
        return $user->hasRole('doctor-admin', 'doctor-admin-api');
    });
    }
}
