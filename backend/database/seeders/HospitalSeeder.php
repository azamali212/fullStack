<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Create the super admin user
         $user = Hospital::firstOrCreate([
            'email' => 'hospital@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'), // Use the password you want
        ]);
    }
}
