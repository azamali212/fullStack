<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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




        DB::table('dcotors')->insert([
            [
                'name' => 'Dr. Alice Johnson',
                'email' => 'alice.johnson@cityhospital.com',
                'password' => Hash::make('doctor123'),
                'hospital_id' => 1,
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Robert Brown',
                'email' => 'robert.brown@cityhospital.com',
                'password' => Hash::make('doctor123'),
                'hospital_id' => 2,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Emily Davis',
                'email' => 'emily.davis@greenvalleyhospital.com',
                'password' => Hash::make('doctor456'),
                'hospital_id' => 2,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Michael Wilson',
                'email' => 'michael.wilson@greenvalleyhospital.com',
                'password' => Hash::make('doctor456'),
                'hospital_id' => 2,
                'user_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
