<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Call the RolePermissionSeeder
        $this->call(RolePermissionSeeder::class);
        $this->call(SuperAdminSeeder::class);
        $this->call(HospitalSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(AmbulanceServiceSeeder::class);
        $this->call(AmbulanceDriverSeeder::class);
        $this->call(MaintenanceRecordSeeder::class);
        $this->call(EmergencyCallSeeder::class);
        $this->call(ShiftScheduleSeeder::class);
        $this->call(HospitalProfileSeeder::class);
        $this->call(Nurses::class);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
