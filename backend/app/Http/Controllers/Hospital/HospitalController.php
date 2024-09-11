<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\BaseController\BaseCrudController;
use App\Http\Requests\HospitalRequest;
use App\Models\Hospital;
use Illuminate\Support\Facades\Log;
use App\Notifications\HospitalNotification;
use App\Services\SmsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class HospitalController extends BaseCrudController
{
    protected $smsServices;
    public function __construct(SmsServices $smsServices)
    {
        $this->model = Hospital::class;
        $this->smsServices = $smsServices;
    }

    protected function validationRules()
    {
        return (new HospitalRequest())->rules();
    }

    public function index(Request $request) {}






    //Overide Function of store hospital 
    public function store(Request $request)
    {
        //auth()->user()->hasPermissionTo("view hospital");
        $validatedData = $request->validate($this->validationRules());
        // Generate the verification code
        $verificationCode = $this->generateVerificationCode();

        Log::info('Validated Data Before Create: ', $validatedData);
        Log::info('Verification Code Before Create: ' . $verificationCode);

        // Create the hospital with the verification code
        $hospital = $this->model::create(array_merge($validatedData, [
            'verification_code' => $verificationCode,
            'is_verified' => false
        ]));

        // Send SMS notification
        $this->smsServices->send(
            $hospital->phone_number,
            'Your hospital registration was successful. Please check your email for further instructions.'
        );



        $hospital->notify((new HospitalNotification($hospital, 'welcome'))->delay(now()->addMinutes(500)));

        // Queue a confirmation email after the welcome email
        $hospital->notify((new HospitalNotification($hospital, 'confirmation'))->delay(now()->addMinutes(100)));

        // Send verification email
        $hospital->notify(new HospitalNotification($hospital, 'verification', $verificationCode));

        return $this->successResponse($hospital, 'Hospital created and verification email sent. Please verify your email to complete the registration.', 201);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'verification_code' => 'required'
        ]);

        $hospital = Hospital::find($request->hospital_id);

        // Check if the provided verification code matches the stored code
        if ($hospital->verification_code === $request->verification_code) {
            // Update the hospital record to mark it as verified
            $hospital->update([
                'is_verified' => true,
                'verification_code' => null
            ]);

            // Send SMS notification
            $this->smsServices->send(
                $hospital->phone_number,
                'Your email has been verified successfully. Welcome to our platform!'
            );

            Log::info('Hospital ID ' . $hospital->id . ' verified successfully.');

            // Send the welcome and confirmation emails
            try {
                $hospital->notify(new HospitalNotification($hospital, 'welcome'));
                Log::info('Welcome email sent to hospital ID ' . $hospital->id);
            } catch (\Exception $e) {
                Log::error('Failed to send welcome email to hospital ID ' . $hospital->id . ': ' . $e->getMessage());
            }

            try {
                $hospital->notify((new HospitalNotification($hospital, 'confirmation'))->delay(now()->addMinutes(500)));
                Log::info('Confirmation email scheduled for hospital ID ' . $hospital->id);
            } catch (\Exception $e) {
                Log::error('Failed to schedule confirmation email for hospital ID ' . $hospital->id . ': ' . $e->getMessage());
            }

            return $this->successResponse(null, 'Email verified successfully, and welcome and confirmation emails have been sent.');
        }

        return $this->errorResponse('Invalid verification code', 400);
    }

    private function generateVerificationCode()
    {
        // Generate a unique verification code
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function show($id)
    {
        $hospital = $this->model::withCount('dcotors')->findOrFail($id);

        // Format the response data
        $responseData = [
            'id' => $hospital->id,
            'name' => $hospital->name,
            'email' => $hospital->email,
            'phone_number' => $hospital->phone_number,
            'registration_number' => $hospital->registration_number,
            'established_date' => $hospital->established_date,
            'address' => [
                'line1' => $hospital->address_line1,
                'line2' => $hospital->address_line2,
                'city' => $hospital->city,
                'state' => $hospital->state,
                'postal_code' => $hospital->postal_code,
                'country' => $hospital->country,
            ],
            'bed_count' => $hospital->bed_count,
            'specialties' => $hospital->specialties,
            'emergency_services' => $hospital->emergency_services,
            'ambulance_service' => $hospital->ambulance_service,
            'operation_theaters' => $hospital->operation_theaters,
            'emergency_contact_number' => $hospital->emergency_contact_number,
            'fax_number' => $hospital->fax_number,
            'website_url' => $hospital->website_url,
            'contact_person' => [
                'name' => $hospital->contact_person_name,
                'email' => $hospital->contact_person_email,
                'phone' => $hospital->contact_person_phone,
            ],
            'accreditations' => $hospital->accreditations,
            'affiliated_universities' => $hospital->affiliated_universities,
            'insurance_partners' => $hospital->insurance_partners,
            'departments' => json_decode($hospital->departments),
            'visiting_hours' => $hospital->visiting_hours,
            'profile_picture' => $hospital->profile_picture,
            'consultation_fee_range' => $hospital->consultation_fee_range,
            'total_doctors' => $hospital->dcotors_count, // Total number of doctors
        ];

        return $this->successResponse($responseData, 'Hospital and related data retrieved successfully');
    }
}
