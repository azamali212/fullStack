<?php

namespace App\Models\RolePermission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
	use SoftDeletes;
	

	/* protected $table = 'permissions';

	protected $fillable = [
		'name',
		'group',
		'guard_name',
		'created_by',
		'updated_by',
		'deleted_by',
	];

	public function rolePermissions()
	{
		if(\Auth::user()->hasrole('System Administrator')){
			return $this->hasMany('App\Models\RolePermission\RolePermission', 'permission_id')->withTrashed();
		}
		return $this->hasMany('App\Models\RolePermission\RolePermission', 'permission_id');
	} */

}