<?php

use App\Http\Controllers\Auth\SuperAdminLoginController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Models\Hospital;
use Illuminate\Http\Request;
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

Route::post('login', [SuperAdminLoginController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function(){
    // Only accessible by Super Admin
    Route::middleware(['can:super-admin-access'])->group(function () {
        Route::get('/super-admin/dashboard', function () {
            return response()->json(['message' => 'Welcome, Super Admin!']);
        });
        Route::post('/super-admin/logout', [SuperAdminLoginController::class, 'logout']);

         // Hospital Routes
        Route::prefix('hospitals')->group(function() {
            Route::get('index', [HospitalController::class, 'index'])->name('hospitals.index');
            Route::post('store', [HospitalController::class, 'store'])->name('hospitals.store');
            Route::get('show/{id}', [HospitalController::class, 'show'])->name('hospitals.show');
            Route::put('update/{id}', [HospitalController::class, 'update'])->name('hospitals.update');
            Route::delete('destroy/{id}', [HospitalController::class, 'destroy'])->name('hospitals.destroy');
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
}); 
