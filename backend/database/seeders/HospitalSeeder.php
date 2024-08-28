<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        DB::table('hospitals')->insert([
            [
                'name' => 'City Hospital',
                'email' => 'cityhospital@example.com',
                'password' => Hash::make('password123'), // Hashing the password
                'phone_number' => '123-456-7890',
                'registration_number' => Str::uuid(), // Generating a unique UUID for the registration number
                'established_date' => '2000-05-20',
                'address_line1' => '123 Main St',
                'address_line2' => 'Suite 100',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country' => 'USA',
                'bed_count' => 150,
                'specialties' => 'Cardiology, Neurology, Pediatrics',
                'emergency_services' => true,
                'ambulance_service' => true,
                'operation_theaters' => 5,
                'emergency_contact_number' => '123-456-7899',
                'fax_number' => '123-456-7898',
                'website_url' => 'http://www.cityhospital.com',
                'contact_person_name' => 'John Doe',
                'contact_person_email' => 'johndoe@cityhospital.com',
                'contact_person_phone' => '123-456-7891',
                
                // Image Paths
                'profile_picture' => 'images/hospitals/cityhospital/profile.jpg',
                'registration_certificate_image' => 'images/hospitals/cityhospital/registration_certificate.jpg',
                'license_image' => 'images/hospitals/cityhospital/license.jpg',
                'fax_id_image' => 'images/hospitals/cityhospital/fax_id.jpg',
                'other_documents_image' => 'images/hospitals/cityhospital/other_documents.jpg',

                'accreditations' => 'JCI, NABH',
                'affiliated_universities' => 'Harvard Medical School, Johns Hopkins University',
                'insurance_partners' => 'Aetna, Blue Cross, Cigna',
                'departments' => json_encode(['Cardiology', 'Neurology', 'Pediatrics']),
                'visiting_hours' => '8:00 AM - 5:00 PM',
                'consultation_fee_range' => '$100 - $500',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Green Valley Hospital',
                'email' => 'greenvalley@example.com',
                'password' => Hash::make('password456'),
                'phone_number' => '987-654-3210',
                'registration_number' => Str::uuid(),
                'established_date' => '2010-10-10',
                'address_line1' => '456 Green St',
                'address_line2' => '',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'postal_code' => '90001',
                'country' => 'USA',
                'bed_count' => 200,
                'specialties' => 'Orthopedics, Oncology, Dermatology',
                'emergency_services' => true,
                'ambulance_service' => false,
                'operation_theaters' => 6,
                'emergency_contact_number' => '987-654-3219',
                'fax_number' => '987-654-3218',
                'website_url' => 'http://www.greenvalleyhospital.com',
                'contact_person_name' => 'Jane Smith',
                'contact_person_email' => 'janesmith@greenvalley.com',
                'contact_person_phone' => '987-654-3211',
                
                // Image Paths
                'profile_picture' => 'images/hospitals/greenvalley/profile.jpg',
                'registration_certificate_image' => 'images/hospitals/greenvalley/registration_certificate.jpg',
                'license_image' => 'images/hospitals/greenvalley/license.jpg',
                'fax_id_image' => 'images/hospitals/greenvalley/fax_id.jpg',
                'other_documents_image' => 'images/hospitals/greenvalley/other_documents.jpg',

                'accreditations' => 'JCI, NABH',
                'affiliated_universities' => 'Stanford University School of Medicine, UCLA',
                'insurance_partners' => 'UnitedHealthcare, Humana, Anthem',
                'departments' => json_encode(['Orthopedics', 'Oncology', 'Dermatology']),
                'visiting_hours' => '9:00 AM - 6:00 PM',
                'consultation_fee_range' => '$150 - $600',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Green Valley Hospital',
                'email' => 'greenvaljley@example.com',
                'password' => Hash::make('password456'),
                'phone_number' => '987-654-3210',
                'registration_number' => Str::uuid(),
                'established_date' => '2010-10-10',
                'address_line1' => '456 Green St',
                'address_line2' => '',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'postal_code' => '90001',
                'country' => 'USA',
                'bed_count' => 200,
                'specialties' => 'Orthopedics, Oncology, Dermatology',
                'emergency_services' => true,
                'ambulance_service' => false,
                'operation_theaters' => 6,
                'emergency_contact_number' => '987-654-3219',
                'fax_number' => '987-654-3218',
                'website_url' => 'http://www.greenvalleyhospital.com',
                'contact_person_name' => 'Jane Smith',
                'contact_person_email' => 'janesmith@greenvalley.com',
                'contact_person_phone' => '987-654-3211',
                
                // Image Paths
                'profile_picture' => 'images/hospitals/greenvalley/profile.jpg',
                'registration_certificate_image' => 'images/hospitals/greenvalley/registration_certificate.jpg',
                'license_image' => 'images/hospitals/greenvalley/license.jpg',
                'fax_id_image' => 'images/hospitals/greenvalley/fax_id.jpg',
                'other_documents_image' => 'images/hospitals/greenvalley/other_documents.jpg',

                'accreditations' => 'JCI, NABH',
                'affiliated_universities' => 'Stanford University School of Medicine, UCLA',
                'insurance_partners' => 'UnitedHealthcare, Humana, Anthem',
                'departments' => json_encode(['Orthopedics', 'Oncology', 'Dermatology']),
                'visiting_hours' => '9:00 AM - 6:00 PM',
                'consultation_fee_range' => '$150 - $600',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}