<?php

namespace App\Providers;

use App\Models\HospitalRegistrationUser;
use App\Repositories\AmbulanceDriverShiftRepo\AmbulanceDriverShiftRepository;
use App\Repositories\AmbulanceDriverShiftRepo\AmbulanceDriverShiftRepositoryInterface;
use App\Repositories\AmbulanceRepo\AmbulanceDriverRepository;
use App\Repositories\AmbulanceRepo\AmbulanceDriverRepositoryInterface;
use App\Repositories\AmbulanceRepo\AmbulanceServiceRepository;
use App\Repositories\AmbulanceRepo\AmbulanceServiceRepositoryInterface;
use App\Repositories\HospitalRegistrationUserRepo\HospitalRegistrationUserRepository;
use App\Repositories\HospitalRegistrationUserRepo\HospitalRegistrationUserRepositoryInterface;
use App\Repositories\HospitalRepo\HospitalRepository;
use App\Repositories\HospitalRepo\HospitalRepositoryInterface;
use App\Repositories\NursesRepo\NursesRepository;
use App\Repositories\NursesRepo\NursesRepositoryInterface;
use App\Repositories\NursesRepo\ShiftRepository;
use App\Repositories\ShiftRepo\ShiftRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

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
        $this->app->bind(AmbulanceDriverRepositoryInterface::class,  AmbulanceDriverRepository::class);
        $this->app->bind(AmbulanceDriverShiftRepositoryInterface::class,  AmbulanceDriverShiftRepository::class);
        $this->app->bind(NursesRepositoryInterface::class, NursesRepository::class);
        $this->app->bind(ShiftRepositoryInterface::class,ShiftRepository::class);
        $this->app->bind(HospitalRegistrationUserRepositoryInterface::class, HospitalRegistrationUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::useCustomerModel(HospitalRegistrationUser::class);
    }
}
