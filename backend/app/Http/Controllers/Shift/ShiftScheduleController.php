<?php

namespace App\Http\Controllers\Shift;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ShiftScheduleService;
use Illuminate\Http\Request;


class ShiftScheduleController extends Controller
{
    protected $shiftScheduleService;

    public function __construct(ShiftScheduleService $shiftScheduleService)
    {
        $this->shiftScheduleService = $shiftScheduleService;
       // $this->hospitalRepository = $hospitalRepository;
        $this->middleware('auth:api');
        $this->middleware('permission:ShiftSchedule.index', ['only' => ['index']]);
        $this->middleware('permission:ShiftSchedule.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:ShiftSchedule.show', ['only' => ['show']]);
        $this->middleware('permission:ShiftSchedule.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ShiftSchedule.destroy', ['only' => ['destroy']]);
        $this->middleware('permission:ShiftSchedule.assignShift', ['only' => ['assignShift']]);
        //Leaves
        $this->middleware('permission:Leaves.index', ['only' => ['index']]);
        $this->middleware('permission:Leaves.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Leaves.show', ['only' => ['show']]);
        $this->middleware('permission:Leaves.approve', ['only' => ['approve']]);
        $this->middleware('permission:Leaves.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Leaves.destroy', ['only' => ['destroy']]);
    }

    public function assignShift(Request $request, $userId)
    {
        $userId = (int) $userId;

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $name = $user->name;
        $validatedData = $request->validate([
            'ambulance_driver_id' => 'nullable|exists:ambulance_drivers,id',
            'ambulance_service_id' => 'nullable|exists:ambulance_services,id',
            'shift_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'shift_type' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $shift = $this->shiftScheduleService->assignShift($userId, $validatedData);

        return response()->json(['message' => 'Shift assigned successfully.', 'shift' => $shift,'user_name' => $name,], 201);
    }
}
