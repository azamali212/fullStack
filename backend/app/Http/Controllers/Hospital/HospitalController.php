<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\BaseController\BaseCrudController;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends BaseCrudController
{
    public function __construct(){
        $this->model = Hospital::class;
    }

    protected function validationRules() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email|max:255',
            'password' => 'required|string|min:8',
        ];
    }
}
