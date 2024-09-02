<?php

namespace App\Http\Controllers\Auth\HospitalAdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalAdminAuthController extends Controller
{
    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->guard('hospital-admin')->attempt($credentials)) {
            $hospitalAdmin =  Hospital::where('email', $credentials['email'])->first();
            config(['auth.guards.api.provider' => 'hospital-admin']);
            $token = auth()->guard('hospital-admin')->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'user' => $hospitalAdmin,
            'token' => $hospitalAdmin->createToken('Super Admin API Token')->plainTextToken,
            ]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }  
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
