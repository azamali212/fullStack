<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions with specific guards
        $permissions = [
            // Hospital Admin Permissions
            ['name' => 'create hospitals', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'view hospitals', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'edit hospitals', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'delete hospitals', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'create doctors', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'view doctors', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'edit doctors', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'delete doctors', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'create pharmacies', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'view pharmacies', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'edit pharmacies', 'guard_name' => 'hospital-admin-api'],
            ['name' => 'delete pharmacies', 'guard_name' => 'hospital-admin-api'],

            // Doctor Admin Permissions
            ['name' => 'create doctors', 'guard_name' => 'doctor-admin-api'],
            ['name' => 'view doctors', 'guard_name' => 'doctor-admin-api'],
            ['name' => 'edit doctors', 'guard_name' => 'doctor-admin-api'],
            ['name' => 'delete doctors', 'guard_name' => 'doctor-admin-api'],
            ['name' => 'create pharmacies', 'guard_name' => 'doctor-admin-api'],
            ['name' => 'view pharmacies', 'guard_name' => 'doctor-admin-api'],
            ['name' => 'edit pharmacies', 'guard_name' => 'doctor-admin-api'],
            ['name' => 'view patients', 'guard_name' => 'doctor-admin-api'],
            ['name' => 'delete patients', 'guard_name' => 'doctor-admin-api'],

            // Pharmacy Admin Permissions
            ['name' => 'view hospitals', 'guard_name' => 'pharmacy-admin-api'],
            ['name' => 'view pharmacies', 'guard_name' => 'pharmacy-admin-api'],
            ['name' => 'edit pharmacies', 'guard_name' => 'pharmacy-admin-api'],
            ['name' => 'view doctors', 'guard_name' => 'pharmacy-admin-api'],
            ['name' => 'view patients', 'guard_name' => 'pharmacy-admin-api'],
            ['name' => 'delete patients', 'guard_name' => 'pharmacy-admin-api'],

            // Patient Permissions
            ['name' => 'view hospitals', 'guard_name' => 'patient-api'],
            ['name' => 'view pharmacies', 'guard_name' => 'patient-api'],
            ['name' => 'view doctors', 'guard_name' => 'patient-api'],
            ['name' => 'create patients', 'guard_name' => 'patient-api'],
            ['name' => 'view patients', 'guard_name' => 'patient-api'],
            ['name' => 'edit patients', 'guard_name' => 'patient-api'],
            ['name' => 'delete patients', 'guard_name' => 'patient-api'],

            // People Permissions
            ['name' => 'view hospitals', 'guard_name' => 'people-api'],
            ['name' => 'view doctors', 'guard_name' => 'people-api'],
            ['name' => 'view pharmacies', 'guard_name' => 'people-api'],
            ['name' => 'create peoples', 'guard_name' => 'people-api'],
            ['name' => 'view peoples', 'guard_name' => 'people-api'],
            ['name' => 'edit peoples', 'guard_name' => 'people-api'],
            ['name' => 'delete peoples', 'guard_name' => 'people-api'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name'], 'guard_name' => $perm['guard_name']]);
        }

        // Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'super-admin-api']);
        $hospitalAdminRole = Role::firstOrCreate(['name' => 'hospital-admin', 'guard_name' => 'hospital-admin-api']);
        $doctorAdminRole = Role::firstOrCreate(['name' => 'doctor-admin', 'guard_name' => 'doctor-admin-api']);
        $pharmacyAdminRole = Role::firstOrCreate(['name' => 'pharmacy-admin', 'guard_name' => 'pharmacy-admin-api']);
        $patientRole = Role::firstOrCreate(['name' => 'patient', 'guard_name' => 'patient-api']);
        $peopleRole = Role::firstOrCreate(['name' => 'people', 'guard_name' => 'people-api']);

        // Assign Permissions to Roles
        $superAdminRole->givePermissionTo(Permission::where('guard_name', 'super-admin-api')->get());

        $hospitalAdminRole->givePermissionTo([
            'view hospitals',
            'edit hospitals',
            'create doctors',
            'view doctors',
            'edit doctors',
            'delete doctors',
            'create pharmacies',
            'view pharmacies',
            'edit pharmacies',
            'delete pharmacies',
        ]);

        $doctorAdminRole->givePermissionTo([
            'view doctors',
            'edit doctors',
            'delete doctors',
            'view pharmacies',
            'view patients',
            'delete patients',
        ]);

        $pharmacyAdminRole->givePermissionTo([
            'view hospitals',
            'view pharmacies',
            'edit pharmacies',
            'view doctors',
            'view patients',
            'delete patients',
        ]);

        $patientRole->givePermissionTo([
            'view hospitals',
            'view pharmacies',
            'view doctors',
            'create patients',
            'view patients',
            'edit patients',
            'delete patients',
        ]);

        $peopleRole->givePermissionTo([
            'view hospitals',
            'view doctors',
            'view pharmacies',
            'create peoples',
            'view peoples',
            'edit peoples',
            'delete peoples',
        ]);
    }
}