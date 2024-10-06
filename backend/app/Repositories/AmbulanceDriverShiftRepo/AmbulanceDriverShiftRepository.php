<?php

namespace App\Repositories\AmbulanceDriverShiftRepo;

use App\Models\AmbulanceDriver;
use App\Models\AmbulanceService;
use App\Models\ShiftSchedule;
use App\Notifications\BaseNotificationSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AmbulanceDriverShiftRepository implements AmbulanceDriverShiftRepositoryInterface
{
    public function getAllDriverShift($request)
    {

        $query = ShiftSchedule::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('shift_date', 'like', "%{$search}%")
                    ->orWhere('start_time', 'like', "%{$search}%")
                    ->orWhere('end_time', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'desc');
        $query->orderBy($sortBy, $order);

        return $query->paginate(10);
    }
    public function createDriverShift($request)
    {

        $ambulanceDrivershift = ShiftSchedule::create($request->validated());

        return $ambulanceDrivershift;
    }
    public function updateDriverShift($request, $id) {}
    public function showDriverShift($id) {}
    public function assignShiftAndAmbulance($driverId, $ambulanceId, $shiftDetails)
    {
        // Find driver and ambulance by their IDs
        $driver = AmbulanceDriver::findOrFail($driverId);
        $ambulance = AmbulanceService::findOrFail($ambulanceId);

        // Assign the ambulance to the driver
        $driver->ambulance_service_id = $ambulance->id;
        $driver->save();

        // Create a new shift and include ambulance_service_id
        $shift = ShiftSchedule::create([
            'ambulance_driver_id' => $driver->id,
            'ambulance_service_id' => $ambulance->id, // Add this field to the shift schedule
            'shift_date' => $shiftDetails['shift_date'],
            'start_time' => $shiftDetails['start_time'],
            'end_time' => $shiftDetails['end_time'],
            'shift_type' => $shiftDetails['shift_type'],
            'notes' => $shiftDetails['notes'],
        ]);

        // Log the driver-ambulance assignment into another table
        DB::table('driver_ambulance_assignments')->insert([
            'ambulance_driver_id' => $driver->id,
            'ambulance_service_id' => $ambulance->id,
            'shift_schedule_id' => $shift->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send notifications for shift and ambulance assignments
        Notification::send($driver, new BaseNotificationSystem($driver, 'shift_assignment', null, $ambulance, $shift));
        Notification::send($driver, new BaseNotificationSystem($driver, 'ambulance_assignment', null, $ambulance, $shift));

        return $shift;
    }
}
