<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AmbulanceDriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'degree' => $this->degree,
            'license_number' => $this->license_number,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'profile_image' => $this->profile_image,
            
            // Ambulance Service Information
            'ambulance_service' => [
                'id' => $this->ambulanceService->id,
                'license_plate' => $this->ambulanceService->license_plate,
                'type' => $this->ambulanceService->type,
                'status' => $this->ambulanceService->status,
            ],
            
            // Hospital Information
            'hospital' => [
                'id' => $this->hospital->id,
                'name' => $this->hospital->name,
                'address' => $this->hospital->address,
                'phone_number' => $this->hospital->phone_number,
            ],
            
            // Shift Schedules
            'shift_schedules' => $this->shiftSchedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'shift_date' => $schedule->shift_date,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'shift_type' => $schedule->shift_type,
                    'notes' => $schedule->notes,
                ];
            }),
            
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];

    }
}
