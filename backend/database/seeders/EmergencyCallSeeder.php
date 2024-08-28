<?php

namespace Database\Seeders;

use App\Models\EmergencyCall;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmergencyCallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmergencyCall::create([
            'call_time' => '2024-08-25 10:00:00',
            'location' => '123 Elm Street',
            'details' => 'Patient suffering from chest pain.',
            'patient_id' => 1, // Assuming this ID exists in the patients table
            'ambulance_service_id' => 1, // Assuming this ID exists in the ambulance_services table
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        EmergencyCall::create([
            'call_time' => '2024-08-26 14:30:00',
            'location' => '456 Maple Avenue',
            'details' => 'Accident with multiple injuries.',
            'patient_id' => 2, // Assuming this ID exists in the patients table
            'ambulance_service_id' => 2, // Assuming this ID exists in the ambulance_services table
            'status' => 'In Progress',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        EmergencyCall::create([
            'call_time' => '2024-08-26 14:30:01',
            'location' => '456 Maple Avenuer',
            'details' => 'Accident with muliple injuries.',
            'patient_id' => 2, // Assuming this ID exists in the patients table
            'ambulance_service_id' => 3, // Assuming this ID exists in the ambulance_services table
            'status' => 'In Progress',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
