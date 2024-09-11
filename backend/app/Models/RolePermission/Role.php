<?php

namespace App\Models\RolePermission;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Role extends SpatieRole
{
	
	use SoftDeletes;
	
	/* protected $table = 'roles';

	public function permissions()
	{
		return $this->belongsToMany('App\Models\RolePermission\RolePermission')->withTimestamps();
	} */

}