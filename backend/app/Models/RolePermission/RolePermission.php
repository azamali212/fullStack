<?php

namespace App\Models\RolePermission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;

class RolePermission extends Model
{
	use SoftDeletes;

	protected $table = 'role_has_permissions';

	protected $fillable = [
		'permission_id',
		'role_id',
	];

	public function role()
	{
		return $this->belongsTo('App\Models\RolePermission\Role', 'role_id', 'id');
	}
}