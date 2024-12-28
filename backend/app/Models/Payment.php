<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_registration_user_id',
        'transaction_id',
        'payment_method',
        'amount',
        'status',
        'payment_gateway',
    ];

    public function hospitalRegistrationUser()
    {
        return $this->belongsTo(HospitalRegistrationUser::class);
    }
}
