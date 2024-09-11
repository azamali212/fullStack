<?php

use App\Http\Controllers\Auth\DoctorAdminAuth\DoctorAdminAuthController;
use App\Http\Controllers\Auth\HospitalAdminAuth\HospitalAdminAuthController;
use App\Http\Controllers\Auth\SuperAdminLoginController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\RolePermission\RoleController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('role', [RoleController::class, 'index'])->middleware('permission:roles.index');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
   // Route::get('role/create', [RoleController::class, 'create'])->middleware('permission:roles.create');
    Route::post('role/store', [RoleController::class, 'store'])->middleware('permission:roles.store');
});

