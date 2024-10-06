<?php

namespace App\Repositories\AmbulanceDriverShiftRepo;

interface AmbulanceDriverShiftRepositoryInterface

{
    //public function getAmbulanceChartData();
    public function getAllDriverShift($request);
    public function createDriverShift($request);
    public function updateDriverShift($request, $id);
    //public function verifyCode($request);
    public function showDriverShift($id);
    public function assignShiftAndAmbulance($driverId, $ambulanceId, $shiftDetails);
}

