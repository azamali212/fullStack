<?php

namespace Database\Seeders;

use App\Models\RolePermission\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $master_admin = User::create([
           // 'role_id' => '1',
            'name' => 'master',

            'email' => 'dpe.developer001@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        $hospitalAdmin = User::create([
            //'role_id' => '2',
            'name' => 'hospital',
            'email' => 'admin@laravel-adminlte.com',
            'hospital_id' => 1,
            'password' => bcrypt('admin'),
        ]);
        $admin = User::create([
            //'role_id' => '2',
            'name' => 'next',
            'email' => 'admin@gmail.com',

            'hospital_id' => 2,
            'password' => bcrypt('admin'),
        ]);




        $nurses = User::create([
            //'role_id' => '2',
            'name' => 'nurses',
            'email' => 'nurses@laravel-adminlte.com',

            'password' => bcrypt('admin'),
        ]);

        $doctors = User::create([
            //'role_id' => '2',
            'name' => 'doctor',
            'email' => 'doctors@laravel-adminlte.com',
            'hospital_id' => 1,
            'password' => bcrypt('admin'),
        ]);

        $master_admin->assignRole(1);
        $admin->assignRole(2);
        $hospitalAdmin->assignRole(2);
        $nurses->assignRole(4);
        $doctors->assignRole(3);
    }
}
