<?php

namespace App\Http\Controllers\Ambulance;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAmbulanceServiceRequest;
use App\Http\Resources\AmbulanceServiceResource;
use App\Models\AmbulanceService;
use App\Repositories\AmbulanceRepo\AmbulanceServiceRepository;
use App\Repositories\AmbulanceRepo\AmbulanceServiceRepositoryInterface;
use Illuminate\Http\Request;

class AmbulanceServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $ambulanceServiceRepository;

    public function __construct(AmbulanceServiceRepositoryInterface $ambulanceServiceRepository)
    {
        $this->ambulanceServiceRepository = $ambulanceServiceRepository;
        $this->middleware('auth:api');
        $this->middleware('permission:AmbulanceService.index', ['only' => ['index']]);
        $this->middleware('permission:AmbulanceService.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:AmbulanceService.show', ['only' => ['show']]);
        $this->middleware('permission:AmbulanceService.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:AmbulanceService.destroy', ['only' => ['destroy']]);
        //$this->middleware('permission:hospitals.profileSetting', ['only' => ['profileSetting']]);
    }

    public function getAmbulanceServiceChartData()
    {
        $counts = $this->ambulanceServiceRepository->getAmbulanceChartData();

        $data = [];
        foreach ($counts as $count) {
            $data[$count->date] = $count->count;
        }

        // Get the total count of hospitals
        $totalCount = AmbulanceService::count();

        // Return the response in JSON format
        return response()->json([
            'status' => 'success',
            'data' => [
                'dailyCounts' => $data, // Daily counts of hospitals registered
                'totalCount' => $totalCount, // Total count of hospitals
            ],
            'message' => 'Chart data retrieved successfully'
        ]);
    }
    public function index(Request $request)
    {
        $ambulanceService = $this->ambulanceServiceRepository->getAllAmbulance($request);

        return AmbulanceServiceResource::collection($ambulanceService)
            ->additional([
                'status' => 'success',
                'message' => 'Ambulance Service retrieved successfully'
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAmbulanceServiceRequest $request)
    {
        // Use the repository to create the ambulance service
        $ambulanceService = $this->ambulanceServiceRepository->createAmbulance($request);

        // Return the response with the created ambulance service ID
        return response()->json([
            'status' => 'success',
            'message' => 'Verification email sent. Please verify your email before proceeding.',
            'ambulance_service_id' => $ambulanceService->id // Corrected variable usage
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ambulanceService = $this->ambulanceServiceRepository->showAmbulance($id);

        return response()->json([
            'status' => 'success',
            'ambulance' => $ambulanceService,
        ], 201);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAmbulanceServiceRequest $request, $id)
    {
        $ambulanceService = $this->ambulanceServiceRepository->updateAmbulance($request, $id);

        return response()->json([
            'status' => 'success',
            'message' => 'Hospital updated successfully',
            'ambulance' => new AmbulanceServiceResource($ambulanceService)
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
