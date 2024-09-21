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
            'name.required' => 'Hospital name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'The email address is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Passwords do not match.',
            'role.required' => 'Role is required.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.max' => 'Phone number cannot exceed 20 characters.',
            'registration_number.required' => 'Registration number is required.',
            'registration_number.unique' => 'The registration number is already registered.',
            'established_date.required' => 'Established date is required.',
            'established_date.date' => 'Please provide a valid date.',
            'address_line1.required' => 'Address line 1 is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'postal_code.required' => 'Postal code is required.',
            'country.required' => 'Country is required.',
            'bed_count.required' => 'Bed count is required.',
            'bed_count.integer' => 'Bed count must be a number.',
            'bed_count.min' => 'Bed count must be at least 1.',
            'specialties.required' => 'Specialties are required.',
            'emergency_services.required' => 'Please specify if emergency services are available.',
            'emergency_services.boolean' => 'Emergency services must be true or false.',
            'ambulance_service.required' => 'Please specify if ambulance service is available.',
            'ambulance_service.boolean' => 'Ambulance service must be true or false.',
            'operation_theaters.integer' => 'Operation theaters count must be a number.',
            'emergency_contact_number.required' => 'Emergency contact number is required.',
            'fax_number.max' => 'Fax number cannot exceed 20 characters.',
            'website_url.url' => 'Please provide a valid URL.',
            'contact_person_name.required' => 'Contact person name is required.',
            'contact_person_email.required' => 'Contact person email is required.',
            'contact_person_email.email' => 'Please provide a valid email for the contact person.',
            'contact_person_phone.required' => 'Contact person phone number is required.',
            'profile_picture.image' => 'Profile picture must be an image.',
            'profile_picture.mimes' => 'Profile picture must be a file of type: jpeg, png, jpg, gif.',
            'profile_picture.max' => 'Profile picture cannot be larger than 2MB.',
            'registration_certificate_image.image' => 'Registration certificate image must be an image.',
            'license_image.image' => 'License image must be an image.',
            'fax_id_image.image' => 'Fax ID image must be an image.',
            'other_documents_image.image' => 'Other documents image must be an image.',
        ];
    }
}
