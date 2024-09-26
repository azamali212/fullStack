<?php

namespace App\Repositories\AmbulanceRepo;

interface AmbulanceServiceRepositoryInterface

{
    public function getAmbulanceChartData();
    public function getAllAmbulance($request);
    public function createAmbulance($request);
    public function updateAmbulance($request, $id);
    public function verifyCode($request);
    public function showAmbulance($id);
}

