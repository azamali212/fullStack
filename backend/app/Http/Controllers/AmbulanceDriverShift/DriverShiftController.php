<?php

namespace App\Http\Controllers\AmbulanceDriverShift;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAmbulanceDriverRequest;
use App\Http\Requests\StoreAmbulanceDriverShiftRequest;
use App\Http\Resources\AmbulanceDriverShiftResource;
use App\Repositories\AmbulanceDriverShiftRepo\AmbulanceDriverShiftRepositoryInterface;
use Illuminate\Http\Request;

class DriverShiftController extends Controller
{
    protected $ambulanceDriverShiftRepository;

    public function __construct(AmbulanceDriverShiftRepositoryInterface $ambulanceDriverShiftRepository)
    {
        $this->ambulanceDriverShiftRepository = $ambulanceDriverShiftRepository;
        $this->middleware('auth:api');
        $this->middleware('permission:AmbulanceDriverShift.index', ['only' => ['index']]);
        $this->middleware('permission:AmbulanceDriverShift.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:AmbulanceDriverShift.show', ['only' => ['show']]);
        $this->middleware('permission:AmbulanceDriverShift.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:AmbulanceDriverShift.destroy', ['only' => ['destroy']]);
        $this->middleware('permission:AmbulanceDriverShift.request', ['only' => ['request']]);
        $this->middleware('permission:AmbulanceDriverShift.ambulanceAssgin', ['only' => ['ambulanceAssgin']]);
        $this->middleware('permission:AmbulanceDriverShift.shiftAssgin', ['only' => ['shiftAssgin']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ambulanceDriverShift = $this->ambulanceDriverShiftRepository->getAllDriverShift($request);

        return response()->json(
            AmbulanceDriverShiftResource::collection($ambulanceDriverShift)
                ->additional([
                    'status' => 'success',
                    'message' => 'Ambulance Driver Shifts retrieved successfully'
                ]),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAmbulanceDriverShiftRequest $request)
    {
        //dd("jlo");
        $ambulanceDriverShift = $this->ambulanceDriverShiftRepository->createDriverShift($request);

        return response()->json(['data' => $ambulanceDriverShift, 'message' => 'Ambulance Driver created and notification sent']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function assignShiftAndAmbulance(Request $request, $driverId, $ambulanceId)
    {
        $shiftDetails = $request->only(['shift_date', 'start_time', 'end_time', 'shift_type', 'notes']);
        $shift = $this->ambulanceDriverShiftRepository->assignShiftAndAmbulance($driverId, $ambulanceId, $shiftDetails);

        return response()->json(['shift' => $shift], 200);
    }
}
