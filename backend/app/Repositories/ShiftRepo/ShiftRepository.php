<?php

namespace App\Repositories\ShiftRepo;

use App\Models\ShiftSchedule;
use App\Notifications\BaseNotificationSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

use function PHPUnit\Framework\returnValue;

class ShiftRepository implements ShiftRepositoryInterface
{
    public function create($data)
    {

        return ShiftSchedule::create($data);
    }
    public function getShiftsByUser($userId)
    {
        return ShiftSchedule::where('user_id', $userId)->get();
    }
    public function getShiftsByDate($date)
    {
        return ShiftSchedule::where('shift_date', $date)->get();
    }
    public function updateStatus($id, $status)
    {
        $shift = ShiftSchedule::find($id);
        if ($shift) {
            $shift->status = $status;
            $shift->save();
        }
        return $shift;
    }
}
