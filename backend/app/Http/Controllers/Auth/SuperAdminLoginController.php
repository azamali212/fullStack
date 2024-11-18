<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get the credentials from the request
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // Create the token
            $token = $user->createToken('authToken')->plainTextToken;

            // Include the user's role and permissions
            $role = $user->getRoleNames()->first(); // Assuming the user has only one role
            $permissions = $user->getAllPermissions()->pluck('name');
            $name = $user->name;

            // Return the response with the token, role, and permissions
            return response()->json([
                'success' => true,
                'token' => $token,
                'role' => $role,
                'permissions' => $permissions,
                'name' => $name,
            ])
            ->cookie('XSRF-TOKEN', csrf_token(), 60, '/', null, false, true)  // Set CSRF token
            ->cookie('token', $token, 60, '/', null, false, true); // Set auth token
        }

        // If login fails, return an error response
        return response()->json([
            'success' => false,
            'error' => 'Invalid credentials'
        ], 401);
    }

    // Logout Super Admin
    public function logout(Request $request)
    {
        // Delete the user's current access token
        $request->user()->currentAccessToken()->delete();

        // Return a successful logout message
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
