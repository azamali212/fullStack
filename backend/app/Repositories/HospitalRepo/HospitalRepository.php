<?php

namespace App\Repositories\HospitalRepo;

use App\Models\Hospital;
use App\Notifications\HospitalNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class HospitalRepository implements HospitalRepositoryInterface
{
    public function getHospitalChartData()
    {
        return Hospital::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::today()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function getAllHospitals($request)
    {
        $query = Hospital::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('specialties', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'desc');
        $query->orderBy($sortBy, $order);

        return $query->paginate(10);
    }

    public function createHospital($request)
    {
        $hospital = Hospital::create($request->validated());

        // Generate a unique verification code
        $verificationCode = Str::random(32);

        // Store the verification code in the hospital_notifications table
        DB::table('hospital_notifications')->updateOrInsert(
            ['hospital_id' => $hospital->id],
            ['status' => 'pending', 'verification_code' => $verificationCode]
        );

        // Send the verification email with the code
        Notification::send($hospital, new HospitalNotification($hospital, 'verification', $verificationCode));

        return $hospital;
    }

    public function updateHospital($request, $id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->update($request->validated());

        Notification::send($hospital, new HospitalNotification($hospital, 'update'));

        return $hospital;
    }

    public function verifyCode($request)
    {
        $hospital = Hospital::where('email', $request->input('email'))->first();
        $notification = DB::table('hospital_notifications')
            ->where('hospital_id', $hospital->id)
            ->where('verification_code', $request->input('verification_code'))
            ->first();

        if (!$notification) {
            return false;
        }

        DB::table('hospital_notifications')->where('id', $notification->id)->update(['status' => 'completed']);
        $hospital->email_verified_at = now();
        $hospital->save();

        return true;
    }
}
