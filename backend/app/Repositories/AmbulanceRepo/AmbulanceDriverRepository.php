<?php

namespace App\Repositories\AmbulanceRepo;

use App\Models\AmbulanceDriver;
use App\Models\AmbulanceService;
use App\Models\ShiftSchedule;
use App\Notifications\BaseNotificationSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AmbulanceDriverRepository implements AmbulanceDriverRepositoryInterface
{
    public function getAmbulanceChartData()
    {
        return AmbulanceDriver::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::today()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function getAllAmbulanceDriver($request)
    {
        $query = AmbulanceDriver::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('license_plate', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'desc');
        $query->orderBy($sortBy, $order);

        return $query->paginate(10);
    }

    public function createAmbulanceDriver($request)
    {
        // Create the ambulance service using the request data
        $ambulanceDriver = AmbulanceDriver::create($request->validated());

        Notification::send($ambulanceDriver, new BaseNotificationSystem($ambulanceDriver, 'verification', $request->verification_code));

        return $ambulanceDriver;
    }

    public function updateAmbulanceDriver($request, $id)
    {
        $ambulanceDriver = AmbulanceDriver::findOrFail($id);
        $ambulanceDriver->update($request->validated());

        Notification::send($ambulanceDriver, new BaseNotificationSystem($ambulanceDriver, 'update'));

        return $ambulanceDriver;
    }
    public function verifyCode($request) {}

    public function assignShiftAndAmbulance($driverId, $ambulanceId, $shiftDetails)
    {

        $driver = AmbulanceDriver::findOrFail($driverId);
        $ambulance = AmbulanceService::findOrFail($ambulanceId);

        // Assign the ambulance to the driver
        $driver->ambulance_service_id = $ambulance->id;
        $driver->save();

        $shift = ShiftSchedule::create([
            'ambulance_driver_id' => $driver->id,
            'shift_date' => $shiftDetails['shift_date'],
            'start_time' => $shiftDetails['start_time'],
            'end_time' => $shiftDetails['end_time'],
            'shift_type' => $shiftDetails['shift_type'],
            'notes' => $shiftDetails['notes'],
        ]);

        DB::table('driver_ambulance_assignments')->insert([
            'ambulance_driver_id' => $driver->id,
            'ambulance_service_id' => $ambulance->id,
            'shift_schedule_id' => $shift->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //dd($shift, $ambulance);
        Notification::send($driver, new BaseNotificationSystem($driver, 'shift_assignment', null, $ambulance, $shift));
        Notification::send($driver, new BaseNotificationSystem($driver, 'ambulance_assignment', null, $ambulance, $shift));

        return $shift;
    }


    public function showAmbulanceDriver($id)
    {
        $ambulanceDriver = AmbulanceDriver::findOrFail($id);

        return $ambulanceDriver;
    }
}
