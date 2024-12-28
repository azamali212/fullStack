<?php

namespace App\Http\Controllers\OrgnaizationWebsite;

use App\Repositories\HospitalRegistrationUserRepo\HospitalRegistrationUserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\HospitalRegistrationUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class HospitalRegistrationUserController extends Controller
{
    protected $userRepo;

    /**
     * Inject the repository into the controller.
     *
     * @param  \App\Repositories\HospitalRegistrationUserRepo\HospitalRegistrationUserRepositoryInterface  $userRepo
     */
    public function __construct(HospitalRegistrationUserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Handle the registration of a hospital registration user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $verificationCode = Str::random(32);
        // Validate incoming registration data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospital_registration_users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['verification_code'] = $verificationCode;
        $validated['is_verified'] = false;
        // Call the repository method to create a user and send verification email
        // Pass the validated data directly as an array
        $user = $this->userRepo->registerHospitalRegistrationUser($validated);

        return response()->json([
            'message' => 'Registration successful. Please check your email for verification.',
            'user' => $user
        ], 201);
    }

    /**
     * Handle the login for a hospital registration user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate login data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Find the user by email
        $user = HospitalRegistrationUser::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Check if the user is verified
        if (!$user->is_verified) {
            return response()->json(['error' => 'Your account is not verified yet.'], 400);
        }

        // Generate a token
        $token = $user->createToken('HospitalRegistrationApp')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,  // Send token in response
        ], 200);
    }

    /**
     * Get all hospital registration users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        // Call the repository to fetch all users with filters
        $users = $this->userRepo->getAllHRU($request);

        return response()->json($users);
    }

    public function verifyEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|string|size:32',
        ]);

        // Call the repository method for verification
        return $this->userRepo->verifyEmail($validated['email'], $validated['verification_code']);
    }

    public function logout(Request $request)
{
    return $this->userRepo->logoutUser($request);
}
}
