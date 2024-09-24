<?php

namespace App\Providers;

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
