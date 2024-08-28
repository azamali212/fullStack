<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    use HasFactory;

     // Define the table associated with the model
     protected $table = 'maintenance_records';

     // Define the fillable attributes for mass assignment
     protected $fillable = [
        'ambulance_service_id',
        'maintenance_date',
        'maintenance_type',
        'description',
        'actions_taken',
        'cost',
    ];

    /**
     * Get the ambulance service associated with the maintenance record.
     */
    public function ambulanceService()
    {
        return $this->belongsTo(AmbulanceService::class, 'ambulance_service_id');
    }
}
