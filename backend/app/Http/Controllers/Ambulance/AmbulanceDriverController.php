<?php

namespace App\Http\Controllers\Ambulance;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAmbulanceDriverRequest;
use App\Http\Resources\AmbulanceDriverResource;
use App\Repositories\AmbulanceRepo\AmbulanceDriverRepositoryInterface;
use Illuminate\Http\Request;

class AmbulanceDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $ambulanceDriverRepository;

     public function __construct(AmbulanceDriverRepositoryInterface $ambulanceDriverRepository)
     {
         $this->ambulanceDriverRepository = $ambulanceDriverRepository;
         $this->middleware('auth:api');
         $this->middleware('permission:AmbulanceDriver.index', ['only' => ['index']]);
         $this->middleware('permission:AmbulanceDriver.create', ['only' => ['create', 'store']]);
         $this->middleware('permission:AmbulanceDriver.show', ['only' => ['show']]);
         $this->middleware('permission:AmbulanceDriver.edit', ['only' => ['edit', 'update']]);
         $this->middleware('permission:AmbulanceDriver.destroy', ['only' => ['destroy']]);
         //$this->middleware('permission:hospitals.profileSetting', ['only' => ['profileSetting']]);
     }
    public function index(Request $request)
    {
        $ambulanceDriver = $this->ambulanceDriverRepository->getAllAmbulanceDriver($request);

        return AmbulanceDriverResource::collection($ambulanceDriver)
        ->additional([
            'status' => 'success',
            'message' => 'Ambulance Driver retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAmbulanceDriverRequest $request)
    {
          // Use the repository to create the ambulance service
          $ambulanceDriver = $this->ambulanceDriverRepository->createAmbulanceDriver($request);

          // Return the response with the created ambulance service ID
          return response()->json(['data' => $ambulanceDriver, 'message' => 'Ambulance Driver created and notification sent']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ambulanceDriver = $this->ambulanceDriverRepository->showAmbulanceDriver($id);

        return response()->json([
            'status' => 'success',
            'ambulance' => $ambulanceDriver,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAmbulanceDriverRequest $request, $id)
    {
        $ambulanceDriver = $this->ambulanceDriverRepository->updateAmbulanceDriver($request,$id);

        return response()->json([
            'status' => 'success',
            'data' => $ambulanceDriver,
            'message' => 'Ambulance Driver created and notification sent',
            'ambulance' => new AmbulanceDriverResource($ambulanceDriver)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
