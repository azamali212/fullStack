<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dcotor;
use App\Models\Hospital;
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

        // Retrieve user by email
        $user = User::where('email', $request->email)->first();

        // Verify user and password
        if ($user && Hash::check($request->password, $user->password)) {
            // Generate token
            $token = $user->createToken('authToken')->plainTextToken;

            // Load roles and permissions dynamically
            $user->load('roles', 'permissions');

            // Initialize variables
            $hospital = null;
            $dcotors = [];

            if ($user->hasRole('Doctor')) {
                // Check if the user is linked to a dcotor record
                $dcotor = $user->dcotor;  // Access the associated dcotor

                if ($dcotor) {
                    $hospital = $dcotor->hospital;
                    $dcotors = [$dcotor];
                }
            } elseif ($user->hasRole('Hospital Administrator')) {
                $hospital = $user->hospital;
                $dcotors = $hospital ? $hospital->dcotors : [];
            } else {
                // For other roles
                $hospital = null;
                $dcotors = [];
            }

            // Debugging
            logger('Hospital:', [$hospital]);
            logger('Doctors:', [$dcotors]);

            return response()->json([
                'success' => true,
                'token' => $token,
                'role' => $user->roles->pluck('name'),
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'name' => $user->name,
                'hospital' => $hospital,
                'dcotors' => $dcotors,

            ], 200)->cookie('XSRF-TOKEN', csrf_token(), 60, '/', null, false, true)
                ->cookie('token', $token, 60, '/', null, false, true);
        }

        // Invalid login
        return response()->json([
            'success' => false,
            'error' => 'Invalid credentials',
        ], 401);
    }

    // Logout Super Admin
    public function logout(Request $request)
    {
        // Ensure user is authenticated
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            $cookie = cookie('XSRF-TOKEN', null, -1); // Expire CSRF token cookie
            $cookie2 = cookie('token', null, -1); // Expire auth token cookie

            return response()->json(['message' => 'Logged out successfully'])->withCookie($cookie)->withCookie($cookie2);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
