<?php

use App\Http\Controllers\Auth\DoctorAdminAuth\DoctorAdminAuthController;
use App\Http\Controllers\Auth\HospitalAdminAuth\HospitalAdminAuthController;
use App\Http\Controllers\Auth\SuperAdminLoginController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\RolePermission\PermissionController;
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

Route::middleware('auth:api')->group(function () {
    Route::get('role', [RoleController::class, 'index'])->middleware('permission:roles.index');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:roles.show');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:roles.edit');
    Route::post('role/store', [RoleController::class, 'store'])->middleware('permission:roles.store');
    Route::get('permission', [PermissionController::class, 'index'])->middleware('permission:permissions.index');
    Route::post('permissions/store', [PermissionController::class, 'store'])->middleware('permission:permissions.create');
    Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('show')->middleware('permission:permissions.show');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->middleware('permission:permissions.edit');
});

