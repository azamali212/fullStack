<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Dcotor;
use App\Models\Hospital;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index(){
       $hospital = Hospital::withCount('dcotors')->get();

       $totalhospital = $hospital->count();
       return response()->json(['total_hospitals' => $totalhospital,
            'hospitals' => $hospital]);
    }
    
}
