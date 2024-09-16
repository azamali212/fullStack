<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:users.index', ['only' => ['index']]);
        $this->middleware('permission:users.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users.show', ['only' => ['show']]);
        $this->middleware('permission:users.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::select('*');
        if (Auth::user()->hasrole('System Administrator')) {
            $users->withTrashed();
        } else {
            $users->where('id', '!=', '1');
        }
        $data = [
            'users' => $users->get()
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required', 'exists:roles,name'],  // Ensure role exists in the roles table
            'permissions' => ['required', 'array'],  // Permissions array is required
            'permissions.*' => ['exists:permissions,name'],  // Each permission must exist
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // Find the role by name
        $role = \Spatie\Permission\Models\Role::where('name', $request->get('role'))->first();

        // Create the user and save role_id in the user table
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' => $role->id,  // Save role_id in users table
        ]);

        // Assign role using Spatie method
        $user->assignRole($request->get('role'));

        $user->syncPermissions($request->get('permissions'));

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        if (Auth::user()->hasRole('System Administrator')) {
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this user.'
            ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, User $user)
    {
        // Allow access to trashed users if the user is an admin
        if (Auth::user()->hasRole('System Administrator')) {
            $user = User::withTrashed()->find($user->id);
        } else {
            $user = User::find($user->id);
        }

        $request->validate([
            'role' => ['required'],  // Ensure role exists in the roles table
            'permissions' => ['nullable', 'array'],  // Permissions array is optional
            'permissions.*' => ['exists:permissions,name'],  // Each permission must exist
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        // Prepare user data for update
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ];

        // If password is provided, update it
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->get('password'));
        }

        // Update user details
        $user->update($data);
        // dd($user);

        // Find the new role
        $role = \Spatie\Permission\Models\Role::where('name', $request->get('role'))->first();

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.'
            ], 404);
        }

        // Sync Roles: This should update the role in the `model_has_roles` table
        $user->syncRoles([$request->get('role')]);

        // Check if the role is updated in the database
        $userRolesInDb = DB::table('model_has_roles')->where('model_id', $user->id)->get();
        //dd($userRolesInDb);  // Check if the role is being updated here
        //$userRolesInDb->update($data);

        // Sync permissions if provided
        if ($request->has('permissions')) {
            $user->syncPermissions($request->get('permissions'));
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),  // Return role names
                'permissions' => $user->getPermissionNames(),  // Return permission names
            ]
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
