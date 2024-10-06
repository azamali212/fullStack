<?php

namespace Database\Seeders;

use App\Models\ShiftSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShiftSchedule::create([
            'ambulance_driver_id' => 1, // Assuming this ID exists in the ambulance_drivers table
            'ambulance_service_id' => 2,
            'shift_date' => '2024-08-25',
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'shift_type' => 'Day',
            'notes' => 'Regular shift.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ShiftSchedule::create([
            'ambulance_driver_id' => 2, // Assuming this ID exists in the ambulance_drivers table
            'ambulance_service_id' => 1,
            'shift_date' => '2024-08-25',
            'start_time' => '16:00:00',
            'end_time' => '00:00:00',
            'shift_type' => 'Night',
            'notes' => 'Covering night shift.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ShiftSchedule::create([
            'ambulance_driver_id' => 3, // Assuming this ID exists in the ambulance_drivers table
            'ambulance_service_id' => 3,
            'shift_date' => '2024-08-25',
            'start_time' => '16:00:00',
            'end_time' => '00:00:00',
            'shift_type' => 'Night',
            'notes' => 'Covering night shift.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
