<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalProfile extends Model
{
    use HasFactory;

    protected $fillable = ['hospital_id', 'name', 'profile_image', 'phone_number', 'email', 'degree'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
