<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'registration_number' => $this->registration_number,
            'established_date' => $this->established_date,
            'address' => [
                'line1' => $this->address_line1,
                'line2' => $this->address_line2,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
            ],
            'bed_count' => $this->bed_count,
            'specialties' => $this->specialties,
            'emergency_services' => $this->emergency_services,
            'ambulance_service' => $this->ambulance_service,
            'operation_theaters' => $this->operation_theaters,
            'emergency_contact_number' => $this->emergency_contact_number,
            'fax_number' => $this->fax_number,
            'website_url' => $this->website_url,
            'contact_person' => [
                'name' => $this->contact_person_name,
                'email' => $this->contact_person_email,
                'phone' => $this->contact_person_phone,
            ],
            'accreditations' => $this->accreditations,
            'affiliated_universities' => $this->affiliated_universities,
            'insurance_partners' => $this->insurance_partners,
            'departments' => json_decode($this->departments),
            'visiting_hours' => $this->visiting_hours,
            'consultation_fee_range' => $this->consultation_fee_range,
            'profile_picture' => url($this->profile_picture),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
