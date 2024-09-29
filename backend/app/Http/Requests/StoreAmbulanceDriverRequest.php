<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmbulanceDriverRequest extends FormRequest
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
            'email' => 'required|email|unique:ambulance_drivers,email',
            'password' => 'required|string|min:8|confirmed',
            'age' => 'nullable|integer|min:18|max:65',
            'degree' => 'nullable|string|max:255',
            'license_number' => 'required|string|max:255|unique:ambulance_drivers,license_number',
            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            //'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ambulance_service_id' => 'required|exists:ambulance_services,id',
            'hospital_id' => 'required|exists:hospitals,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'An ambulance driver with this email already exists.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'license_number.required' => 'The license number field is required.',
            'license_number.unique' => 'An ambulance driver with this license number already exists.',
            'phone_number.required' => 'The phone number field is required.',
            'ambulance_service_id.required' => 'The ambulance service ID field is required.',
            'ambulance_service_id.exists' => 'The selected ambulance service ID is invalid.',
            'hospital_id.required' => 'The hospital ID field is required.',
            'hospital_id.exists' => 'The selected hospital ID is invalid.',
        ];
    }
}
