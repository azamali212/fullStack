<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Hospital extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \Spatie\Permission\Traits\HasRoles;

    protected $guard =  'hospital';

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

    //Profile 
    public function profile()
    {
        return $this->hasOne(HospitalProfile::class);
    }

    public function ambulances()
    {
        return $this->hasMany(AmbulanceService::class);
    }

     // A hospital belongs to a super admin (user)
     public function user()
     {
         return $this->belongsTo(User::class);
     }

     public function nurse()
     {
         return $this->hasMany(Nurse::class);
     }


    // Relationships for permissions
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
                    ->where('model_type', self::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id', 'permission_id')
                    ->where('model_type', self::class);
    }
    /**
     * 
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
