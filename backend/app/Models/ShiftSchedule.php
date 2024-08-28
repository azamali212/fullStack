<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftSchedule extends Model
{
    use HasFactory;

     // Define the table associated with the model
     protected $table = 'shift_schedules';

     // Define the fillable attributes for mass assignment
     protected $fillable = [
        'ambulance_driver_id',
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
}
