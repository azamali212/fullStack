<?php

namespace App\Repositories\HospitalRepo;

interface HospitalRepositoryInterface

{
    public function getHospitalChartData();
    public function getAllHospitals($request);
    public function createHospital($request);
    public function updateHospital($request, $id);
    public function verifyCode($request);
}

