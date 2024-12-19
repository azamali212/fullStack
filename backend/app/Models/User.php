<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        //'role_id',
        'name',
        'email',
        'password',
        'hospital_id'
    ];

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

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');  // This is the correct relationship
    }

    public function dcotor()
    {
        return $this->hasOne(Dcotor::class, 'user_id');  // Assuming the foreign key is 'user_id' in the dcotors table
    }

    public function role()
	{
		return $this->belongsTo('App\Models\RolePermission\UserRole', 'id', 'model_id');
	}
}
