<?php

namespace Database\Seeders;

use App\Models\AmbulanceService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmbulanceServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AmbulanceService::create([
            'license_plate' => 'ABC-1234',
            'status' => 'available',
            'hospital_id' => 1, // Ensure this hospital exists
            'type' => 'Basic Life Support',
            'make' => 'Ford',
            'model' => 'Transit',
            'year' => 2018,
            'color' => 'White',
            'features' => json_encode(['Oxygen Supply', 'Stretcher', 'First Aid Kit']),
            'maintenance_record' => json_encode(['2022-06-01' => 'Oil Change', '2023-01-15' => 'Brake Inspection']),
        ]);

        AmbulanceService::create([
            'license_plate' => 'XYZ-5678',
            'status' => 'in_service',
            'hospital_id' => 1, // Ensure this hospital exists
            'type' => 'Advanced Life Support',
            'make' => 'Mercedes-Benz',
            'model' => 'Sprinter',
            'year' => 2020,
            'color' => 'Red',
            'features' => json_encode(['Defibrillator', 'Ventilator', 'IV Equipment']),
            'maintenance_record' => json_encode(['2023-03-10' => 'Tire Replacement', '2023-08-22' => 'Engine Check']),
        ]);

        AmbulanceService::create([
            'license_plate' => 'LMN-9101',
            'status' => 'maintenance',
            'hospital_id' => 2, // Ensure this hospital exists
            'type' => 'Critical Care Transport',
            'make' => 'Chevrolet',
            'model' => 'Express',
            'year' => 2016,
            'color' => 'Blue',
            'features' => json_encode(['Cardiac Monitor', 'Infusion Pump', 'Portable Suction Unit']),
            'maintenance_record' => json_encode(['2023-05-05' => 'Battery Replacement', '2023-07-11' => 'Transmission Service']),
        ]);
    }
}
