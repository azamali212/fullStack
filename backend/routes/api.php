<?php

use App\Http\Controllers\Auth\HospitalAdminAuth\HospitalAdminAuthController;
use App\Http\Controllers\Auth\SuperAdminLoginController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Hospital\HospitalController;
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



    // Only accessible by Super Admin
    Route::middleware(['auth:sanctum,can:super-admin-access'])->group(function () {
        Route::get('/super-admin/dashboard',[SuperAdminController::class,'index'])->name('index');
        Route::post('/super-admin/logout', [SuperAdminLoginController::class, 'logout']);

         // Hospital Routes
        Route::prefix('hospitals')->group(function() {
            Route::get('hospitals', [HospitalController::class, 'index'])->name('hospitals.index');
            Route::post('store', [HospitalController::class, 'store'])->name('hospitals.store');
            Route::get('show/{id}', [HospitalController::class, 'show'])->name('hospitals.show');
            Route::put('update/{id}', [HospitalController::class, 'update'])->name('hospitals.update');
            Route::delete('destroy/{id}', [HospitalController::class, 'destroy'])->name('hospitals.destroy');
            Route::get('/hospitals/{id}', [HospitalController::class, 'show']);
            Route::post('/hospitals/verify-email', [HospitalController::class, 'verifyEmail']);
        });

        // Doctor Routes
        Route::prefix('doctors')->group(function() {
            Route::get('index', [DoctorController::class, 'index'])->name('doctors.index');
            Route::post('store', [DoctorController::class, 'store'])->name('doctors.store');
            Route::get('show/{id}', [DoctorController::class, 'show'])->name('doctors.show');
            Route::put('update/{id}', [DoctorController::class, 'update'])->name('doctors.update');
            Route::delete('destroy/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
        });
    });

    //Only accessible by hospital adminclear
     // Only accessible by Hospital Admin
     Route::middleware(['auth:sanctum,can:hospital-admin-access'])->group(function () {
        
        Route::post('/hospitalAdmin/logout', [HospitalAdminAuthController::class, 'logout']);
    });

