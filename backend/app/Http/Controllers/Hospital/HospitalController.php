<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\BaseController\BaseCrudController;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends BaseCrudController
{
    public function __construct(){
        $this->model = Hospital::class;
    }

    protected function validationRules() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email|max:255',
            'password' => 'required|string|min:8',
        ];
    }

    public function show($id) {
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
