<?php

namespace Database\Seeders;

use App\Models\HospitalProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HospitalProfile::factory()->count(5)->create();
    }
}
