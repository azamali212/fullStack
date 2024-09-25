<?php

namespace App\Providers;

use App\Repositories\AmbulanceRepo\AmbulanceServiceRepository;
use App\Repositories\AmbulanceRepo\AmbulanceServiceRepositoryInterface;
use App\Repositories\HospitalRepo\HospitalRepository;
use App\Repositories\HospitalRepo\HospitalRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HospitalRepositoryInterface::class, HospitalRepository::class);
        $this->app->bind(AmbulanceServiceRepositoryInterface::class,  AmbulanceServiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
