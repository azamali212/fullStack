<?php

namespace App\Repositories\ShiftRepo;

interface ShiftRepositoryInterface

{
    public function create($data);
    public function getShiftsByUser($userId);
    public function getShiftsByDate($date);
    public function updateStatus($id,$status);
}

