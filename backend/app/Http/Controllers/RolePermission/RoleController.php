<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
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
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        // $role = SpatieRole::create(['name' => $request->input('name')]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        // Load permissions with the role data
        $role->load('permissions');

        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }

    public function show(Role $role)
    {
        // Load permissions associated with the role
        $role->load('permissions');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name'),
                'deleted_at' => $role->deleted_at
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required|array',
        ]);

        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        $role->load('permissions');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name'),
            ]
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
