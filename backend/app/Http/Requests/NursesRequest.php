<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NursesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Return true to authorize the request
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
            'email' => 'required|email|unique:nurses,email,' . $this->nurse,
            'phone_no' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'study_details' => 'nullable|string',
            'pdf_cv' => 'nullable|mimes:pdf|max:2048',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'The email address has already been taken.',
            'phone_no.required' => 'The phone number is required.',
            'phone_no.max' => 'The phone number may not be greater than 15 characters.',
            'city.required' => 'The city is required.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'state.max' => 'The state may not be greater than 255 characters.',
            'postal_code.max' => 'The postal code may not be greater than 20 characters.',
            'country.required' => 'The country is required.',
            'country.max' => 'The country may not be greater than 255 characters.',
            'contact_person_name.max' => 'The contact person name may not be greater than 255 characters.',
            'profile_picture.mimes' => 'The profile picture must be a file of type: jpeg, png, jpg.',
            'profile_picture.max' => 'The profile picture may not be greater than 2MB.',
            'study_details.string' => 'The study details must be a string.',
            'pdf_cv.mimes' => 'The CV must be a PDF file.',
            'pdf_cv.max' => 'The CV may not be greater than 2MB.',
        ];
    }
}