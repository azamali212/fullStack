<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'name',
        'email',
        'password',
        'role',
        'phone_number',
        'registration_number',
        'established_date',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'bed_count',
        'specialties',
        'emergency_services',
        'ambulance_service',
        'operation_theaters',
        'emergency_contact_number',
        'fax_number',
        'website_url',
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'accreditations',
        'affiliated_universities',
        'insurance_partners',
        'departments',
        'visiting_hours',
        'profile_picture',
        'consultation_fee_range',
        'verification_code', 
        'is_verified',
        // Images
        'registration_certificate_image',
        'license_image',
        'fax_id_image',
        'other_documents_image',
    ];

     // One hospital has many doctors
     public function dcotors(): HasMany
    {
        return $this->hasMany(Dcotor::class);
    }

    public function ambulances()
    {
        return $this->hasMany(AmbulanceService::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
