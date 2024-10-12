<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Nurse extends Model
{
    use HasFactory , Notifiable;

    protected $fillable = [
        'name', 'email', 'phone_no', 'city', 'state', 'postal_code', 'country', 
        'contact_person_name', 'profile_picture', 'study_details', 'pdf_cv','hospital_id'
    ];

    public function hospital()
     {
         return $this->belongsTo(Hospital::class);
     }
}
