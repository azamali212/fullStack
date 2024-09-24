<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\BaseController\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalRequest;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;
use App\Notifications\HospitalNotification;
use App\Repositories\HospitalRepo\HospitalRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{

    protected $hospitalRepository;
    public function __construct(HospitalRepositoryInterface $hospitalRepository)
    {
        $this->hospitalRepository = $hospitalRepository;
        $this->middleware('auth:api');
        $this->middleware('permission:hospitals.index', ['only' => ['index']]);
        $this->middleware('permission:hospitals.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:hospitals.show', ['only' => ['show']]);
        $this->middleware('permission:hospitals.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:hospitals.destroy', ['only' => ['destroy']]);
        $this->middleware('permission:hospitals.profileSetting', ['only' => ['profileSetting']]);
    }


    public function getHospitalChartData()
    {
        // Get the count of hospitals grouped by date for the last 30 days
        $counts = Hospital::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::today()->subDays(30)) // Change this to the desired number of days
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Format the data for the response
        $data = [];
        foreach ($counts as $count) {
            $data[$count->date] = $count->count;
        }

        // Get the total count of hospitals
        $totalCount = Hospital::count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'dailyCounts' => $data,
                'totalCount' => $totalCount,
            ],
            'message' => 'Chart data retrieved successfully'
        ]);
    }

    public function index(Request $request)
    {
        $hospitals = $this->hospitalRepository->getAllHospitals($request);

        return HospitalResource::collection($hospitals)
            ->additional([
                'status' => 'success',
                'message' => 'Hospitals retrieved successfully'
            ]);
    }

    public function store(HospitalRequest $request)
    {
        // Create a hospital first
        $hospital = Hospital::create($request->validated());

        // Generate a unique verification code
        $verificationCode = Str::random(32);

        // Store the verification code in the hospital_notifications table
        DB::table('hospital_notifications')->updateOrInsert(
            ['hospital_id' => $hospital->id],
            ['status' => 'pending', 'verification_code' => $verificationCode]
        );

        // Send the verification email with the code
        Notification::send($hospital, new HospitalNotification($hospital, 'verification', $verificationCode));

        return response()->json([
            'status' => 'success',
            'message' => 'Verification email sent. Please verify your email before proceeding.',
            'hospital_id' => $hospital->id // You might want to return the ID for reference
        ], 201);
    }

    //Email Verification
    // public function sendVerificationEmail(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|exists:hospitals,email',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Invalid email address',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $hospital = Hospital::where('email', $request->input('email'))->first();
    //     $verificationCode = Str::random(32); // Generate a unique verification code

    //     // Store the verification code in the database
    //     DB::table('hospital_notifications')->updateOrInsert(
    //         ['hospital_id' => $hospital->id],
    //         ['status' => 'pending', 'verification_code' => $verificationCode] // Ensure 'verification_code' is saved
    //     );

    //     // Send verification email with the code
    //     Notification::send($hospital, new HospitalNotification($hospital, 'verification', $verificationCode));

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Verification code sent to email'
    //     ]);
    // }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:hospitals,email',
            'verification_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 422);
        }

        $hospital = Hospital::where('email', $request->input('email'))->first();
        $notification = DB::table('hospital_notifications')
            ->where('hospital_id', $hospital->id)
            ->where('verification_code', $request->input('verification_code'))
            ->first();

        if (!$notification) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired verification code'
            ], 400);
        }

        // Update the notification status
        DB::table('hospital_notifications')->where('id', $notification->id)->update(['status' => 'completed']);

        // Update the hospital's email_verified field
        $hospital->email_verified_at = now(); // Set the timestamp for email verification
        $hospital->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Email verified successfully'
        ]);
    }

    public function update(HospitalRequest $request, $id)
    {
        $hospital = Hospital::findOrFail($id);

        $hospital->update($request->validated());

        Notification::send($hospital, new HospitalNotification($hospital, 'update'));

        return response()->json([
            'status' => 'success',
            'message' => 'Hospital updated successfully. A confirmation email has been sent.',
            'hospital' => new HospitalResource($hospital), // Assuming you're using a resource
        ]);
    }
}
