<?php

use App\Events\ShiftAssignedEvent;
use App\Models\ShiftSchedule;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-shift', function () {
     // Retrieve the user (adjust the ID as needed)
     $user = User::find(1);

     // Retrieve an existing shift schedule (adjust the ID as needed)
     $shift = ShiftSchedule::find(1);

     // Check if both the user and shift exist
     if (!$user || !$shift) {
         return 'User or Shift not found!';
     }

     // Fire the event
     event(new ShiftAssignedEvent($user, $shift));

     return 'Shift Assigned event triggered!';
});
