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
        $counts = $this->hospitalRepository->getHospitalChartData();

        $data = [];
        foreach ($counts as $count) {
            $data[$count->date] = $count->count;
        }

        // Get the total count of hospitals
        $totalCount = Hospital::count();

        // Return the response in JSON format
        return response()->json([
            'status' => 'success',
            'data' => [
                'dailyCounts' => $data, // Daily counts of hospitals registered
                'totalCount' => $totalCount, // Total count of hospitals
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
        $hospital = $this->hospitalRepository->createHospital($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Verification email sent. Please verify your email before proceeding.',
            'hospital_id' => $hospital->id
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
        $result = $this->hospitalRepository->verifyCode($request);

        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired verification code'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Email verified successfully'
        ]);
    }

    //http://localhost:8025/ and also php artisan queue work for run nitifcation
    public function update(HospitalRequest $request, $id)
    {
        $hospital = $this->hospitalRepository->updateHospital($request, $id);

        return response()->json([
            'status' => 'success',
            'message' => 'Hospital updated successfully',
            'hospital' => new HospitalResource($hospital)
        ]);
    }
}
