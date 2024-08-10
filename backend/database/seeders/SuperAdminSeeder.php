<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or retrieve the super-admin role
        $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'super-admin-api']);

        // Create the super admin user
        $user = User::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'), // Use the password you want
        ]);

        // Assign the role to the user
        $user->assignRole($role);
    }
}
