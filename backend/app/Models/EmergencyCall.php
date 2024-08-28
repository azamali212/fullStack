<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyCall extends Model
{
    use HasFactory;

    protected $table = 'emergency_calls';

    // The attributes that are mass assignable.
    protected $fillable = [
        'call_time',
        'location',
        'details',
        'patient_id',
        'ambulance_service_id',
        'status',
    ];

    /**
     * Get the patient associated with the emergency call.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Get the ambulance service associated with the emergency call.
     */
    public function ambulanceService()
    {
        return $this->belongsTo(AmbulanceService::class, 'ambulance_service_id');
    }
}
