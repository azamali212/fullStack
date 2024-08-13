<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\BaseController\BaseCrudController;
use App\Models\Dcotor;
use Illuminate\Http\Request;

class DoctorController extends BaseCrudController
{
    public function __construct(){
        $this->model = Dcotor::class;
    }

    protected function validationRules() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email|max:255',
            'password' => 'required|string|min:8',
        ];
    }
}
