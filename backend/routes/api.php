<?php

use App\Http\Controllers\Ambulance\AmbulanceDriverController;
use App\Http\Controllers\Ambulance\AmbulanceServiceController;
use App\Http\Controllers\AmbulanceDriverShift\DriverShiftController;
use App\Http\Controllers\Auth\HospitalAdminAuth\HospitalAdminAuthController;
use App\Http\Controllers\Auth\SuperAdminLoginController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\Hospital\HospitalProfileController;
use App\Http\Controllers\Nurses\NursesController;
use App\Http\Controllers\Nurses\NursesProfileController;
use App\Http\Controllers\RolePermission\PermissionController;
use App\Http\Controllers\RolePermission\RoleController;
use App\Http\Controllers\SuperAdmin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Super Admin Authentication Routes
Route::post('super-admin/login', [SuperAdminLoginController::class, 'login'])->name('super-admin.login');

// Hospital Admin Authentication Routes
Route::post('hospital-admin/login', [HospitalAdminAuthController::class, 'login'])->name('hospital-admin.login');

// Doctor Admin Authentication Routes
//Route::post('doctor-admin/login',[DoctorAdminAuthController::class,'login'])->name('doctor-admin.login');

Route::middleware('auth:api')->group(function () {

    //Role Routes
    Route::get('role', [RoleController::class, 'index'])->middleware('permission:roles.index');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:roles.show');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:roles.edit');
    Route::post('role/store', [RoleController::class, 'store'])->middleware('permission:roles.store');

    //Permissions Routes
    Route::get('permission', [PermissionController::class, 'index'])->middleware('permission:permissions.index');
    Route::post('permissions/store', [PermissionController::class, 'store'])->middleware('permission:permissions.create');
    Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('show')->middleware('permission:permissions.show');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->middleware('permission:permissions.edit');

    //User Routes
    Route::get('user', [UserController::class, 'index'])->middleware('permission:users.index');
    Route::post('user/store', [UserController::class, 'store'])->middleware('permission:users.store');
    Route::get('user/{user}', [UserController::class, 'show'])->middleware('permission:users.show');
    Route::put('user/{user}', [UserController::class, 'update'])->middleware('permission:users.edit');

    //Hospital Routes
    Route::get('hospital', [HospitalController::class, 'index'])->middleware('permission:hospitals.index');
    Route::post('hospital/store', [HospitalController::class, 'store'])->middleware('permission:hospitals.create');
    Route::post('hospital/verify-code', [HospitalController::class, 'verifyCode']);
    Route::post('hospital/verify-email', [HospitalController::class, 'sendVerificationEmail']);
    Route::put('hospital/{id}', [HospitalController::class, 'update'])->name('hospital.update')->middleware('permission:hospitals.edit');
    Route::get('/hospitals/chart', [HospitalController::class, 'getHospitalChartData']);

    //Hospital Profile Route
    Route::put('/hospitals/{id}/profile', [HospitalProfileController::class, 'update'])->middleware('permission:hospitals.profileSetting');

    //Ambulance Service Routes
    Route::get('/ambulanceService/chart', [AmbulanceServiceController::class, 'getAmbulanceServiceChartData']);
    Route::get('/ambulanceService', [AmbulanceServiceController::class, 'index'])->middleware('permission:AmbulanceService.index');
    Route::post('ambulanceService/store', [AmbulanceServiceController::class, 'store'])->middleware('permission:AmbulanceService.store');
    Route::put('ambulanceService/{id}', [AmbulanceServiceController::class, 'update'])->name('ambulanceService.update')->name('update')->middleware('permission:AmbulanceService.edit');
    Route::get('ambulanceService/{id}', [AmbulanceServiceController::class, 'show'])->middleware('permission:AmbulanceService.show');

    //Ambulance Driver Routes
    Route::get('/ambulanceService/chart', [AmbulanceDriverController::class, 'getAmbulanceServiceChartData']);
    Route::get('/ambulanceDriver', [AmbulanceDriverController::class, 'index'])->middleware('permission:AmbulanceDriver.index');
    Route::post('ambulanceDriver/store', [AmbulanceDriverController::class, 'store'])->middleware('permission:AmbulanceDriver.store');
    Route::put('ambulanceDriver/{id}', [AmbulanceDriverController::class, 'update'])->name('ambulanceDriver.update')->name('update')->middleware('permission:AmbulanceDriver.edit');
    Route::get('/ambulanceDriver/{id}', [AmbulanceDriverController::class, 'show'])->middleware('permission:AmbulanceDriver.show');
    //Route::post('/drivers/{driverId}/ambulances/{ambulanceId}/assign-shift', [AmbulanceDriverController::class, 'assignShiftAndAmbulance']);
    Route::get('/ambulanceDriverShift', [DriverShiftController::class, 'index'])->middleware('permission:AmbulanceDriverShift.index');
    Route::post('/ambulanceDriverShift/store', [DriverShiftController::class, 'store'])->middleware('permission:AmbulanceDriverShift.store');
    Route::post('assign-shift-ambulance/{driverId}/{ambulanceId}', [DriverShiftController::class, 'assignShiftAndAmbulance'])->name('driver-shifts.assign')->middleware('permission:AmbulanceDriverShift.shiftAssgin');

    //Nurses Routes
    Route::get('/nursesProfile/{id}',[NursesProfileController::class,'show'])->name('nursesProfile.show')->middleware('permission:Nurse.profile.show');
    Route::put('/nursesProfile/{id}', [NursesProfileController::class, 'update'])->name('nursesProfile.update')->middleware('permission:Nurse.profile.update');
    Route::get('/nurses', [NursesController::class, 'index'])->name('nurse.index')->middleware('permission:Nurses.index');
    Route::post('/nurses/store', [NursesController::class, 'store'])->name('nurse.store')->middleware('permission:Nurses.store');
    Route::put('/nurses/{id}', [NursesController::class, 'update'])->name('nurse.update')->middleware('permission:Nurses.edit');
});


