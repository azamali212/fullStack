<?php

namespace App\Repositories\AmbulanceRepo;


use App\Models\AmbulanceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AmbulanceServiceRepository implements AmbulanceServiceRepositoryInterface
{
    public function getAmbulanceChartData()
    {
        return AmbulanceService::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::today()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }
    public function getAllAmbulance($request)
    {
        $query = AmbulanceService::query();

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
    public function createAmbulance($request)
    {
        // Create the ambulance service using the request data
    $ambulanceService = AmbulanceService::create($request->validated());

    return $ambulanceService;
    }
    public function updateAmbulance($request, $id) {
        $ambulanceService = AmbulanceService::findOrFail($id);
        $ambulanceService->update($request->validated());

        return $ambulanceService;
    }
    public function verifyCode($request) {}

    public function showAmbulance($id){
        $ambulanceService = AmbulanceService::findOrFail($id);

        return $ambulanceService;
    }
}
