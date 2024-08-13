<?php

namespace Database\Seeders;

use App\Models\Dcotor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Create the super admin user
         $user = Dcotor::firstOrCreate([
            'email' => 'doctor@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'), // Use the password you want
        ]);
    }
}
