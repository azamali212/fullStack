<?php

namespace Database\Seeders;

use App\Models\AmbulanceDriver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AmbulanceDriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AmbulanceDriver::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('doctor123'),
            'age' => 35,
            'degree' => 'Paramedic Certification',
            'license_number' => 'D123456789',
            'phone_number' => '555-1234',
            'address' => '123 Main St, Anytown',
            'profile_image' => 'path/to/image1.jpg',
            'ambulance_service_id' => 1, // Ensure this ambulance exists
            'hospital_id' => 1,  // Ensure this hospital exists
        ]);

        AmbulanceDriver::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('doctor123'),
            'age' => 40,
            'degree' => 'Advanced Life Support Certification',
            'license_number' => 'D987654321',
            'phone_number' => '555-5678',
            'address' => '456 Elm St, Othertown',
            'profile_image' => 'path/to/image2.jpg',
            'ambulance_service_id' => 2, // Ensure this ambulance exists
            'hospital_id' => 1,  // Ensure this hospital exists
        ]);

        AmbulanceDriver::create([
            'name' => 'Mike Johnson',
            'email' => 'mike.johnson@example.com',
            'password' => Hash::make('doctor123'),
            'age' => 45,
            'degree' => 'First Aid Certification',
            'license_number' => 'D111222333',
            'phone_number' => '555-9101',
            'address' => '789 Oak St, Anothertown',
            'profile_image' => 'path/to/image3.jpg',
            'ambulance_service_id' => 3, // Ensure this ambulance exists
            'hospital_id' => 2,  // Ensure this hospital exists
        ]);

    }
}
