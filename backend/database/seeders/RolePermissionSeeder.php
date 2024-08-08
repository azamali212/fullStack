<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Create Roles 
        $superAdminRole = Role::create(['name'=>'super-admin']);
        $hospitalAdminRole = Role::create(['name' => 'hospital-admin']);
        $dcotorAdminRole = Role::create(['name' => 'dcotor-admin']);
        $pharmacyAdminRole = Role::create(['name' => 'pharmacy-admin']);
        $patientRole = Role::create(['name' => 'patient']);
        $peopleRole = Role::create(['name' => 'people']);

        //Create Permissions for hospital 
        Permission::create(['name' => 'create hospitals']);
        Permission::create(['name' => 'view hospitals']);
        Permission::create(['name' => 'edit hospitals']);
        Permission::create(['name' => 'delete hospitals']);

        //Create Permissions for Dcotor
        Permission::create(['name' => 'create dcotors']);
        Permission::create(['name' => 'view dcotors']);
        Permission::create(['name' => 'edit dcotors']);
        Permission::create(['name' => 'delete dcotors']);

        // Create permissions for patients
        Permission::create(['name' => 'create patients']);
        Permission::create(['name' => 'view patients']);
        Permission::create(['name' => 'edit patients']);
        Permission::create(['name' => 'delete patients']);

        // Create permissions for pharmacies
        Permission::create(['name' => 'create pharmacies']);
        Permission::create(['name' => 'view pharmacies']);
        Permission::create(['name' => 'edit pharmacies']);
        Permission::create(['name' => 'delete pharmacies']);

        // Create permissions for patients
        Permission::create(['name' => 'create patients']);
        Permission::create(['name' => 'view patients']);
        Permission::create(['name' => 'edit patients']);
        Permission::create(['name' => 'delete patients']);

        // Create permissions for peoples
        Permission::create(['name' => 'create peoples']);
        Permission::create(['name' => 'view peoples']);
        Permission::create(['name' => 'edit peoples']);
        Permission::create(['name' => 'delete peoples']);

        //Assgin permissions to Super Admin
        $superAdminRole->givePermissionTo(Permission::all());

        //Assgin permissions to hospital 
        $hospitalAdminRole->givePermissionTo([
            'view hospitals',
            'edit hospitals',
            'delete hospitals',
            'create doctors',
            'view doctors',
            'edit doctors',
            'delete doctors',
            'create pharmacies',
            'view pharmacies',
            'edit pharmacies',
            'delete pharmacies',
            'create patients',
            'view patients',
            'edit patients',
            'delete patients',
        ]);

         //Assgin permissions to Dcotor 
         $dcotorAdminRole->givePermissionTo([
            'view dcotors',
            'edit dcotors',
            'view pharmacies',
            'edit pharmacies',
            'create patients',
            'view patients',
            'edit patients',
            'delete patients',
        ]);

        //Assgin permissions to patients
        $patientRole->givePermissionTo([
            'view hospitals',
            'view pharmacies',
            'view dcotors',
            'create patients',
            'view patients',
            'edit patients',
            'delete patients',
        ]);

        //Assgin permissions to People
        $peopleRole->givePermissionTo([
            'view hospitals',
            'view dcotors',
            'view pharmacies',
            'create peoples',
            'view peoples',
            'edit peoples',
            'delete peoples',
        ]);

    }
}
