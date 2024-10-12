<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NursesResource extends JsonResource
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
            'phone_no' => $this->phone_no,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'contact_person_name' => $this->contact_person_name,
            'profile_picture' => $this->profile_picture ? url('storage/' . $this->profile_picture) : null, // Provide full URL for profile picture
            'study_details' => $this->study_details,
            'pdf_cv' => $this->pdf_cv ? url('storage/' . $this->pdf_cv) : null, // Provide full URL for CV
            'hospital' => [
                'id' => $this->hospital->id ?? null,
                'name' => $this->hospital->name ?? null,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
