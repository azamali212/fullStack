<?php

use App\Http\Controllers\Auth\SuperAdminLoginController;
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

Route::post('login', [SuperAdminLoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    // Only accessible by Super Admin
    Route::middleware(['can:super-admin-access'])->group(function () {
        Route::get('/super-admin/dashboard', function () {
            return response()->json(['message' => 'Welcome, Super Admin!']);
        });
    });
});
