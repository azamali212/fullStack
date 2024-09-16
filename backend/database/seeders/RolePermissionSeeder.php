<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        ini_set('memory_limit', '2048M');
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Permission::truncate();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'roles.index',
            'roles.show',
            'roles.create',
            'roles.store',
            'roles.edit',
            'roles.destroy',
            'permissions.index',
            'permissions.create',
            'permissions.show',
            'permissions.edit',
            'permissions.destroy',
            'users.index',
            'users.show',
            'users.create',
            'users.store',
            'users.edit',
            'users.destroy',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'view_posts',
            'manage_users',
            'view_reports',
            'approve_comments',
            'delete_comments'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'group' => 'default']);
        }

        // Create roles
        $roles = [
            'System Administrator' => [
                'roles.index',
                'roles.show',
                'roles.create',
                'roles.store',
                'roles.edit',
                'roles.destroy',
                'permissions.index',
                'permissions.create',
                'permissions.show',
                'permissions.edit',
                'permissions.destroy',
                'users.index',
                'users.show',
                'users.create',
                'users.store',
                'users.edit',
                'users.destroy',
                'create_posts',
                'edit_posts',
                'delete_posts',
                'view_posts',
                'manage_users',
                'view_reports',
                'approve_comments',
                'delete_comments'
            ],
            'Administrator' => [
                'create_posts',
                'edit_posts',
                'view_posts',
                'manage_users',
                'view_reports',
                'approve_comments'
            ],
            'Editor' => [
                'create_posts',
                'edit_posts',
                'view_posts',
                'approve_comments'
            ],
            'User' => [
                'view_posts'
            ]
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($permissions);
        }
    }
}
