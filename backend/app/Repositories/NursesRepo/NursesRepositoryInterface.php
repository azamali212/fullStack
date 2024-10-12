<?php

namespace App\Repositories\NursesRepo;

interface NursesRepositoryInterface

{
    public function getAllNurses($request);
    public function createNurses($request);
    public function updateNurses($request, $id);
    public function verifyCode($request);
}

