<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class AmbulanceDriver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'degree',
        'license_number',
        'phone_number',
        'address',
        'profile_image',
        'ambulance_service_id', // Should be 'ambulance_service_id' not 'ambulance_id'
        'hospital_id',
    ];

    /**
     * Get the hospital where the driver is employed.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * Get the ambulance assigned to the driver.
     */
    public function ambulanceService()
    {
        return $this->belongsTo(AmbulanceService::class, 'ambulance_service_id');
    }

    /**
     * Define the relationship with the ShiftSchedule model.
     */
    public function shiftSchedules()
    {
        return $this->hasMany(ShiftSchedule::class, 'ambulance_driver_id');
    }
}
