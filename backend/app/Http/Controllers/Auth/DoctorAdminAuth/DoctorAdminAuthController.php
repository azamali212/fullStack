<?php

namespace App\Http\Controllers\Auth\DoctorAdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Dcotor;
use Illuminate\Http\Request;

class DoctorAdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->guard('doctor-admin')->attempt($credentials)) {
            $doctorAdmin =  Dcotor::where('email', $credentials['email'])->first();
            config(['auth.guards.api.provider' => 'doctor-admin']);
            $token = auth()->guard('doctor-admin')->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'user' => $doctorAdmin,
                'token' => $doctorAdmin->createToken('Doctor Admin API Token')->plainTextToken,
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
