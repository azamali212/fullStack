<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmbulanceServiceRequest extends FormRequest
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
            'license_plate' => 'required|unique:ambulance_services,license_plate',
            'status' => 'required|string',
            'hospital_id' => 'nullable|exists:hospitals,id',
            'type' => 'nullable|string',
            'make' => 'nullable|string',
            'model' => 'nullable|string',
            'year' => 'nullable|integer',
            'color' => 'nullable|string',
            'features' => 'nullable|string',
            'maintenance_record' => 'nullable|string',
        ];
    }
}
