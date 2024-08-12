<?php

namespace App\Http\Controllers\BaseController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseCrudController extends Controller
{
    protected $model;

    // Method to return a standardized success response
    protected function successResponse($data, $message = "Operation successful", $status_code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => true,
            'status_code' => $status_code,
        ], $status_code);
    }

    //Validation Rules
    protected function validationsRule()
    {
        return [];
    }
    //Get all Data
    public function index()
    {
        $data = $this->model::all();
        return $this->successResponse($data, 'Items retrieved successfully');
    }

    //Store Data
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules());
        $validatedData['password'] = bcrypt($validatedData['password']);
        $data = $this->model::create($validatedData);
        return $this->successResponse($data, 'Item created successfully', 201);
    }

    //Show Single Date 
    public function show($id)
    {
        $data = $this->model::findOrFail($id);
        return $this->successResponse($data, 'Item retrieved successfully');
    }

    //Update Data
    public function update(Request $request, $id)
    {
        $item = $this->model::findOrFail($id);
        $item->update($request->all());
        return $this->successResponse($item, 'Item updated successfully');
    }

    //Delete Data a
    public function destroy($id)
    {
        $data = $this->model::findOrFail($id);
        $data->delete();
        return $this->successResponse('Item deleted successfully');
    }
}
