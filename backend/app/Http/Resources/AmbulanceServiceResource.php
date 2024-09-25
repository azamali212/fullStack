<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AmbulanceServiceResource extends JsonResource
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
            'license_plate' => $this->license_plate,  
            'status' => $this->status, 
            'hospital_id' => $this->hospital_id,  
            'type' => $this->type,  
            'make' => $this->make, 
            'model' => $this->model,  
            'year' => $this->year, 
            'color' => $this->color,  
            'features' => $this->features,  
            'maintenance_record' => $this->maintenance_record,  
            'created_at' => $this->created_at,  
            'updated_at' => $this->updated_at,   
        ];
    }
}
