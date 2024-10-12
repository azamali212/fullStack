<?php

namespace App\Repositories\NursesRepo;

use App\Models\Nurse;
use App\Notifications\BaseNotificationSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class NursesRepository implements NursesRepositoryInterface
{
    public function getAllNurses($request)
    {

        $query = Nurse::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'desc');
        $query->orderBy($sortBy, $order);

        return $query->paginate(10);
    }
    public function createNurses($request)
    {

        $nurses = Nurse::create($request->validated());

        $verificationCode = Str::random(32);

        Notification::send($nurses, new BaseNotificationSystem($nurses, 'verification', $verificationCode));

        return $nurses;
    }
    public function updateNurses($request, $id) {
        $nurses = Nurse::findOrFail($id);
        $nurses->update($request->validated());

        Notification::send($nurses, new BaseNotificationSystem($nurses, 'update'));

        return $nurses;
    }
    public function verifyCode($request) {}
}
