<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospitalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email,' . $this->route('hospital'),
            'password' => 'required|string|min:8', // Add 'confirmed' if using password confirmation
            'phone_number' => 'nullable|string|max:20',
            'registration_number' => 'required|string|unique:hospitals,registration_number,' . $this->route('hospital'),
            'established_date' => 'nullable|date',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'bed_count' => 'nullable|integer|min:0',
            'specialties' => 'nullable|string',
            'emergency_services' => 'boolean',
            'ambulance_service' => 'boolean',
            'operation_theaters' => 'nullable|integer|min:0',
            'emergency_contact_number' => 'nullable|string|max:20',
            'fax_number' => 'nullable|string|max:20',
            'website_url' => 'nullable|url',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'accreditations' => 'nullable|string',
            'affiliated_universities' => 'nullable|string',
            'insurance_partners' => 'nullable|string',
            'departments' => 'nullable|string', // Update this line to accept an array
            'visiting_hours' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|string|max:255',
            'consultation_fee_range' => 'nullable|string|max:50',
            'registration_certificate_image' => 'nullable|string|max:255',
            'license_image' => 'nullable|string|max:255',
            'fax_id_image' => 'nullable|string|max:255',
            'other_documents_image' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The hospital name is required.',
            'email.required' => 'The hospital email is required.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password is required.',
            'registration_number.required' => 'The registration number is required.',
            'registration_number.unique' => 'The registration number has already been taken.',
        ];
    }
}
