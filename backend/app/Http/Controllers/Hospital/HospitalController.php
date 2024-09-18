<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:hospitals.index', ['only' => ['index']]);
        $this->middleware('permission:hospitals.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:hospitals.show', ['only' => ['show']]);
        $this->middleware('permission:hospitals.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:hospitals.destroy', ['only' => ['destroy']]);
        $this->middleware('permission:hospitals.profileSetting', ['only' => ['profileSetting']]);
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sort_by' => 'in:name,created_at,bed_count', // fields you want to allow sorting on
            'order' => 'in:asc,desc',
            'search' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid parameters',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Hospital::query();


        //Condition Check if the search pass or not 
        if ($request->has('search')) {
            $search = $request->input('search');
            //anonymous function inside the where condition
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('specialties', 'like', "%{$search}%");
            });
        }

        //Sorting
        $sortBy = $request->input('sort_by', 'created_at'); // default sort by created_at
        $order = $request->input('order', 'desc'); // default order desc
        $query->orderBy($sortBy, $order);


        $hospitals = $query->paginate(10);

        return HospitalResource::collection($hospitals)
            ->additional([
                'status' => 'success',
                'message' => 'Hospitals retrieved successfully'
            ]);
    }
}
