<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmbulanceDriverShiftRequest extends FormRequest
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
           'ambulance_driver_id' => 'required|exists:ambulance_drivers,id',
            'shift_date' => 'required|date|after_or_equal:today', 
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'shift_type' => 'nullable|string', 
            'notes' => 'nullable|string|max:255', 
        ];
    }

    public function messages()
    {
        return [
            'ambulance_driver_id.required' => 'The ambulance driver ID is required.',
            'ambulance_driver_id.exists' => 'The specified ambulance driver does not exist.',
            'shift_date.required' => 'The shift date is required.',
            'shift_date.after_or_equal' => 'The shift date must be today or a future date.',
            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'The start time must be in the format HH:mm.',
            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'The end time must be in the format HH:mm.',
            'end_time.after' => 'The end time must be after the start time.',
            'notes.max' => 'The notes may not be longer than 255 characters.',
        ];
    }
}
