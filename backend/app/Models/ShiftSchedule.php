<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class ShiftSchedule extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

     // Define the table associated with the model
     protected $table = 'shift_schedules';

     // Define the fillable attributes for mass assignment
     protected $fillable = [
        'ambulance_driver_id',
        'ambulance_service_id',
        'shift_date',
        'start_time',
        'end_time',
        'shift_type',
        'notes',
    ];

    /**
     * Get the ambulance driver associated with the shift schedule.
     */
    public function ambulanceDriver()
    {
        return $this->belongsTo(AmbulanceDriver::class, 'ambulance_driver_id');
    }

    public function ambulanceService()
    {
        return $this->belongsTo(AmbulanceService::class, 'ambulance_service_id');
    }
}
