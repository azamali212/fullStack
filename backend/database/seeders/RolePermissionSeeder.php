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

            //Shift
            'AmbulanceDriverShift.index',
            'AmbulanceDriverShift.show',
            'AmbulanceDriverShift.create',
            'AmbulanceDriverShift.store',
            'AmbulanceDriverShift.destroy',
            'AmbulanceDriverShift.edit',
            'AmbulanceDriverShift.shiftAssgin',
            'AmbulanceDriverShift.ambulanceAssgin',
            'AmbulanceDriverShift.request',

            //Staff Profile
            'Nurse.profile.show',
            'Nurse.profile.update',

            'Guard.profile.show',
            'Guard.profile.update',

            'Cleaner.profile.show',
            'Cleaner.profile.update',

            'Worker.profile.show',
            'Worker.profile.update',

            //Staff
            'Nurses.index',
            'Nurses.show',
            'Nurses.store',
            'Nurses.create',
            'Nurses.update',
            'Nurses.destroy',
            'Nurses.edit',
            'Cleaner.index',
            'Cleaner.show',
            'Cleaner.create',
            'Cleaner.update',
            'Cleaner.destroy',
            'Cleaner.edit',
            'Guard.index',
            'Guard.show',
            'Guard.create',
            'Guard.update',
            'Guard.destroy',
            'Guard.edit',
            'Worker.index',
            'Worker.show',
            'Worker.create',
            'Worker.update',
            'Worker.destroy',
            'Worker.edit',
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
                'AmbulanceDriverShift.index',
                'AmbulanceDriverShift.show',
                'AmbulanceDriverShift.create',
                'AmbulanceDriverShift.store',
                'AmbulanceDriverShift.destroy',
                'AmbulanceDriverShift.edit',
                'AmbulanceDriverShift.shiftAssgin',
                'AmbulanceDriverShift.ambulanceAssgin',
                //Staff
                'Nurses.index',
                'Nurses.show',
                'Nurses.store',
                'Nurses.create',
                'Nurses.update',
                'Nurses.destroy',
                'Nurses.edit',
                'Cleaner.index',
                'Cleaner.show',
                'Cleaner.create',
                'Cleaner.update',
                'Cleaner.destroy',
                'Cleaner.edit',
                'Guard.index',
                'Guard.show',
                'Guard.create',
                'Guard.update',
                'Guard.destroy',
                'Guard.edit',
                'Worker.index',
                'Worker.show',
                'Worker.create',
                'Worker.update',
                'Worker.destroy',
                'Worker.edit',
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
                'AmbulanceDriverShift.index',
                'AmbulanceDriverShift.show',
                'AmbulanceDriverShift.create',
                'AmbulanceDriverShift.store',
                'AmbulanceDriverShift.destroy',
                'AmbulanceDriverShift.request',
                'AmbulanceDriverShift.edit',
                'AmbulanceDriverShift.shiftAssgin',
                'AmbulanceDriverShift.ambulanceAssgin',
                //Staff
                'Nurses.index',
                'Nurses.show',
                'Nurses.store',
                'Nurses.create',
                'Nurses.update',
                'Nurses.destroy',
                'Nurses.edit',
                'Cleaner.index',
                'Cleaner.show',
                'Cleaner.create',
                'Cleaner.update',
                'Cleaner.destroy',
                'Cleaner.edit',
                'Guard.index',
                'Guard.show',
                'Guard.create',
                'Guard.update',
                'Guard.destroy',
                'Guard.edit',
                'Worker.index',
                'Worker.show',
                'Worker.create',
                'Worker.update',
                'Worker.destroy',
                'Worker.edit',
            ],

            'AmbulanceDriverProfile' => [
                'AmbulanceDriverShift.request',
                'AmbulanceDriverShift.show',
                'AmbulanceDriver.show',
            ],

            'Nurses' => [
                'Nurse.profile.show',
                'Nurse.profile.update',
            ],

            'Guard' => [
                'Guard.profile.show',
                'Guard.profile.update',
            ],

            'Cleaner' => [
                'Cleaner.profile.show',
                'Cleaner.profile.update',
            ],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($permissions);
        }
    }
}
