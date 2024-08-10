<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SuperAdminLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate using the 'web' guard to verify credentials
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Get the authenticated user
        $superAdmin = Auth::user();

        // Ensure the user has the 'super-admin' role
        if (!$superAdmin->hasRole('super-admin')) {
            Auth::logout();
            throw ValidationException::withMessages([
                'role' => ['You do not have permission to access this role.'],
            ]);
        }

        // Generate Sanctum token
        return response()->json([
            'user' => $superAdmin,
            'token' => $superAdmin->createToken('Super Admin API Token')->plainTextToken,
        ]);
    }
}