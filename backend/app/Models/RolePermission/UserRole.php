<?php

namespace App\Models\RolePermission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'model_has_roles';

    protected $fillable = [
		'role_id',
		'model_type',
		'model_id',
	];

    public function role()
	{
		return $this->belongsTo('App\Models\RolePermission\Role', 'role_id');
	}
}
