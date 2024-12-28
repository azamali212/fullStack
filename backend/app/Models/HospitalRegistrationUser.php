<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class HospitalRegistrationUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,Billable;


    protected $fillable = [
        'firebase_uid',
        'name',
        'email',
        'password',
        'verification_code',
        'is_verified',
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
