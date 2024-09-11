<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:roles.index', ['only' => ['index']]);
        $this->middleware('permission:roles.show', ['only' => ['show']]);
        $this->middleware('permission:roles.create', ['only' => ['store']]);
        $this->middleware('permission:roles.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:roles.destroy', ['only' => ['destroy']]);
    }

    public function index()
    {
        $activeRoles = Role::where('id', '!=', 1)->whereNull('deleted_at')->get();
        $deletedRoles = collect();

        if (Auth::user()->hasRole('System Administrator')) {
            $deletedRoles = Role::where('id', '!=', 1)->whereNotNull('deleted_at')->get();
        }

        $roles = $activeRoles->merge($deletedRoles);

        return response()->json([
            'success' => true,
            'data' => $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions->pluck('name'),
                    'deleted_at' => $role->deleted_at,
                    'actions' => $this->getActions($role)
                ];
            })
        ]);
    }

    //its a Private meethod that can be used for action in role
    private function getActions($role)
    {
        $actions = [];

        if ($role->id > 2) {
            if ($role->deleted_at !== null) {  // Check for soft deletion without withTrashed()
                $actions[] = [
                    'type' => 'restore',
                    'url' => route('roles.restore', $role->id),
                    'icon' => 'download'
                ];
            } else {
                $actions[] = [
                    'type' => 'delete',
                    'url' => route('roles.destroy', $role->id),
                    'icon' => 'trash-alt'
                ];
            }
        }

        return $actions;
    }

    public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $role = SpatieRole::create(['name' => $request->input('name')]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        return response()->json([
            'success' => true,
            'data' => $role
        ]);
	}

    public function destroy(Role $role)
    {
        // Ensure the role cannot be deleted if it is a special role, like the default admin role
        if ($role->id <= 2) {
            return response()->json(['error' => 'This role cannot be deleted.'], 403);
        }

        // Soft delete the role
        $role->delete();

        return response()->json(['success' => 'Role deleted successfully.']);
    }
}
