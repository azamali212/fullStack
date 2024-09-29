<?php

namespace App\Repositories\AmbulanceRepo;

interface AmbulanceDriverRepositoryInterface

{
    public function getAmbulanceChartData();
    public function getAllAmbulanceDriver($request);
    public function createAmbulanceDriver($request);
    public function updateAmbulanceDriver($request, $id);
    public function verifyCode($request);
    public function showAmbulanceDriver($id);
}

