<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use App\Models\RolePermission\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:permissions.index', ['only' => ['index']]);
        $this->middleware('permission:permissions.create', ['only' => ['store']]);
        $this->middleware('permission:permissions.show', ['only' => ['show']]);
        $this->middleware('permission:permissions.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permissions.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $permissionsQuery = Permission::orderBy('group', 'asc')->select('*');

        // Check if the authenticated user is a 'System Administrator'
        if (Auth::user()->hasRole('System Administrator')) {
            // No withTrashed() because Permission doesn't use SoftDeletes
            $permissionsQuery = Permission::orderBy('group', 'asc')->select('*');
        }

        // If the request is an AJAX call (typically, you'd just return JSON in an API context)
        if ($request->ajax()) {
            $permissions = $permissionsQuery->get();

            return response()->json([
                'success' => true,
                'data' => $permissions->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'group' => $permission->group,
                        'deleted_at' => null, // No soft deletes, so no deleted_at
                        'actions' => $this->getActions($permission),
                    ];
                }),
            ]);
        }

        // If it's not an AJAX request, just return all permissions in JSON format
        return response()->json([
            'success' => true,
            'data' => $permissionsQuery->get(),
        ]);
    }

    // Private method to generate actions for each permission
    private function getActions($permission)
    {
        $actions = [];

        if ($permission->trashed()) {
            $actions[] = [
                'type' => 'restore',
                'url' => route('permissions.restore', $permission->id),
                'icon' => 'download',
            ];
        } else {
            $actions[] = [
                'type' => 'delete',
                'url' => route('permissions.destroy', $permission->id),
                'icon' => 'trash-alt',
            ];
        }

        return $actions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => ['required', 'array'], // 'name' should be an array of permission names
            'name.*' => ['required', 'string', 'unique:permissions,name'], // each permission name should be a string and unique
        ]);

        try {
            ini_set('memory_limit', '1G');

            // Find the role, in this case, role ID 1 (System Administrator)
            $role = Role::findOrFail(1);

            // Iterate through the permission names and create each permission
            foreach ($validatedData['name'] as $key => $name) {
                $permission = Permission::create([
                    'group' => str_replace("_", " ", explode('.', $name)[0]), // generate group from name
                    'name' => $name,
                ]);

                // Assign permission to the role
                $role->givePermissionTo($permission);
            }

            // Return a success response with created permissions
            return response()->json([
                'success' => true,
                'message' => 'Permissions created and assigned to role successfully.',
            ], 201);
        } catch (\Exception $e) {
            // Handle errors and return a failure response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating permissions.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $permission->id,
                'name' => $permission->name,
                'group' => $permission->group,
                'created_at' => $permission->created_at,
                'updated_at' => $permission->updated_at,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'group' => 'required|string|max:255'
        ]);

        // Update the permission
        $permission->update([
            'name' => $request->input('name'),
            'group' => $request->input('group'),
        ]);

        // Clear cached permissions
        Artisan::call('permission:cache-reset');

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully',
            'data' => [
                'id' => $permission->id,
                'name' => $permission->name,
                'group' => $permission->group,
                'updated_at' => $permission->updated_at,
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
