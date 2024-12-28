<?php

namespace App\Repositories\HospitalRegistrationUserRepo;

use App\Models\HospitalRegistrationUser;
use App\Notifications\BaseNotificationSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class HospitalRegistrationUserRepository implements HospitalRegistrationUserRepositoryInterface
{
    public function getAllHRU($request)
    {
        $query = HospitalRegistrationUser::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'desc');
        $query->orderBy($sortBy, $order);

        return $query->paginate(10);
    }

    public function registerHospitalRegistrationUser($validatedData)
    {
        $verificationCode = Str::random(32);

        // Use the validated data directly, no need to call $request->validated()
        $hospitalRegistrationUser = HospitalRegistrationUser::create($validatedData);

        // Send the notification
        Notification::send($hospitalRegistrationUser, new BaseNotificationSystem(
            $hospitalRegistrationUser,
            'verification',
            $hospitalRegistrationUser->verification_code // Use the actual saved value
        ));

        return $hospitalRegistrationUser;
    }

    public function loginHospitalRegistrationUser($request)
    {
        // Validate the login request
        $credentials = $request->only(['email', 'password']);

        // Check if user exists and password matches
        $user = HospitalRegistrationUser::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Check if user is verified
            if (!$user->is_verified) {
                return response()->json(['error' => 'Your account is not verified yet.'], 400);
            }

            // If login is successful, you can optionally issue a token or return the user
            // Example: return $user; or issue a token if you are using Passport or Sanctum
            return $user;
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }


    public function verifyEmail($email, $verificationCode)
    {
        // Find the user by email
        $user = HospitalRegistrationUser::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the verification code matches
        if ($user->verification_code !== $verificationCode) {
            return response()->json(['error' => 'Invalid verification code'], 400);
        }

        // Update user verification status
        $user->is_verified = true;
        $user->verification_code = null;  // Clear the verification code
        $user->save();

        return response()->json(['message' => 'Email successfully verified!']);
    }

    public function logoutUser($request)
{
    // Assuming you are using a token-based authentication system like Laravel Sanctum or Passport.
    if ($request->user()) {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    return response()->json(['error' => 'No authenticated user found'], 401);
}
}
