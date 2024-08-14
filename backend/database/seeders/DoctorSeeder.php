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
        // First, we need to make sure that the hospitals exist and we know their IDs
        $hospital1 = DB::table('hospitals')->where('name', 'City Hospital')->first();
        $hospital2 = DB::table('hospitals')->where('name', 'Green Valley Hospital')->first();

        if (!$hospital1 || !$hospital2) {
            return; // Exit if hospitals are not found
        }

        DB::table('dcotors')->insert([
            [
                'name' => 'Dr. Alice Johnson',
                'email' => 'alice.johnson@cityhospital.com',
                'password' => Hash::make('doctor123'),
                'hospital_id' => $hospital1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Robert Brown',
                'email' => 'robert.brown@cityhospital.com',
                'password' => Hash::make('doctor123'),
                'hospital_id' => $hospital1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Emily Davis',
                'email' => 'emily.davis@greenvalleyhospital.com',
                'password' => Hash::make('doctor456'),
                'hospital_id' => $hospital2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Michael Wilson',
                'email' => 'michael.wilson@greenvalleyhospital.com',
                'password' => Hash::make('doctor456'),
                'hospital_id' => $hospital2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}