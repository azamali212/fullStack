<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceService extends Model
{
    use HasFactory;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_plate',
        'status',
        'hospital_id',
        'type',
        'make',
        'model',
        'year',
        'color',
        'features',
        'maintenance_record',
    ];

    /**
     * Get the hospital that owns the ambulance.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Get the drivers assigned to the ambulance.
     */
    public function drivers()
    {
        return $this->hasMany(AmbulanceDriver::class, 'ambulance_service_id');
    }
}
