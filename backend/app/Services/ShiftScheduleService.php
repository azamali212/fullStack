<?php
namespace App\Services;

use App\Repositories\ShiftRepo\ShiftRepository;
use App\Models\User;
use App\Events\ShiftAssignedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BaseNotificationSystem;

class ShiftScheduleService
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function assignShift($userId, $data)
    {
        $data['user_id'] = (int) $userId;
        $shift = $this->shiftRepository->create($data);

        // Get the user to whom the shift is assigned
        $user = User::findOrFail($userId);
        $name = $user->name;


        // Trigger Pusher event for real-time notification
        event(new ShiftAssignedEvent($user, $shift));

        // Send an email notification
        Notification::send($user, new BaseNotificationSystem($user, 'shift_assignment', null, null, $shift));

        return $shift;
    }
}
