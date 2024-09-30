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
            'hospitals.index',
            'hospitals.show',
            'hospitals.create',
            'hospitals.store',
            'hospitals.edit',
            'hospitals.destroy',
            'hospitals.profileSetting',
            'AmbulanceService.index',
            'AmbulanceService.show',
            'AmbulanceService.create',
            'AmbulanceService.store',
            'AmbulanceService.edit',
            'AmbulanceService.destroy',
            'AmbulanceDriver.index',
            'AmbulanceDriver.show',
            'AmbulanceDriver.create',
            'AmbulanceDriver.store',
            'AmbulanceDriver.destroy',
            'AmbulanceDriver.edit',
            'Ambulance.assignSystem',
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
                'hospitals.index',
                'hospitals.show',
                'hospitals.create',
                'hospitals.store',
                'hospitals.edit',
                'hospitals.destroy',
                'hospitals.profileSetting',
                'AmbulanceService.index',
                'AmbulanceService.show',
                'AmbulanceService.create',
                'AmbulanceService.store',
                'AmbulanceService.edit',
                'AmbulanceService.destroy',
                'AmbulanceDriver.index',
                'AmbulanceDriver.show',
                'AmbulanceDriver.create',
                'AmbulanceDriver.store',
                'AmbulanceDriver.edit',
                'AmbulanceDriver.destroy',
                'Ambulance.assignSystem',
            ],
            'Hospital Administrator' => [
                'hospitals.index',
                'hospitals.profileSetting',
                'AmbulanceService.index',
                'AmbulanceService.show',
                'AmbulanceService.create',
                'AmbulanceService.store',
                'AmbulanceService.edit',
                'AmbulanceService.destroy',
                'AmbulanceDriver.index',
                'AmbulanceDriver.show',
                'AmbulanceDriver.create',
                'AmbulanceDriver.edit',
                'AmbulanceDriver.store',
                'AmbulanceDriver.destroy',
                'Ambulance.assignSystem',
            ],
            'Editor' => [],
            'User' => []
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($permissions);
        }
    }
}
