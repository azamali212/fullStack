<?php

namespace App\Repositories\AmbulanceRepo;

use App\Models\AmbulanceDriver;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    return $ambulanceDriver;
    }
    public function updateAmbulanceDriver($request, $id) {
        $ambulanceDriver = AmbulanceDriver::findOrFail($id);
        $ambulanceDriver->update($request->validated());

        return $ambulanceDriver;
    }
    public function verifyCode($request) {}

    public function showAmbulanceDriver($id){
        $ambulanceDriver = AmbulanceDriver::findOrFail($id);

        return $ambulanceDriver;
    }
}
