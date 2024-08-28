<?php

namespace Database\Seeders;

use App\Models\MaintenanceRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaintenanceRecord::create([
            'ambulance_service_id' => 1, // Assuming this ID exists in the ambulance_services table
            'maintenance_date' => '2024-08-25',
            'maintenance_type' => 'Oil Change',
            'description' => 'Changed the engine oil.',
            'actions_taken' => 'Replaced old oil with new synthetic oil.',
            'cost' => 120.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        MaintenanceRecord::create([
            'ambulance_service_id' => 2, // Assuming this ID exists in the ambulance_services table
            'maintenance_date' => '2024-08-26',
            'maintenance_type' => 'Tire Replacement',
            'description' => 'Replaced worn-out tires.',
            'actions_taken' => 'Installed new tires and balanced them.',
            'cost' => 500.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        MaintenanceRecord::create([
            'ambulance_service_id' => 3, // Assuming this ID exists in the ambulance_services table
            'maintenance_date' => '2024-08-26',
            'maintenance_type' => 'Tire Replacement',
            'description' => 'Replaced worn-out tires.',
            'actions_taken' => 'Installed new tires and balanced them.',
            'cost' => 500.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
