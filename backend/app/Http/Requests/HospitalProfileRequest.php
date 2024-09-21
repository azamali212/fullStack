<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospitalProfileRequest extends FormRequest
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
            'profile_image' => 'nullable|string|max:255',  
            'phone_number' => 'required|string|max:15',              
            'email' => 'required|email|unique:hospital_profiles,email,' . $this->hospital_profile, 
            'degree' => 'nullable|string|max:255', 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'profile_image.image' => 'The profile image must be an image file.',
            //'profile_image.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif.',
            'profile_image.max' => 'The profile image must not exceed 2MB in size.',
            'phone_number.required' => 'The phone number is required.',
            'email.required' => 'The email is required.',
            'email.unique' => 'This email is already taken.',
        ];
    }
}
