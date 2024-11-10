<?php

namespace App\Events;

use App\Models\ShiftSchedule;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShiftAssignedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $shift;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, ShiftSchedule $shift)
    {
        $this->user = $user;
        $this->shift = $shift;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id);
    }
    public function broadcastAs()
    {
        return 'shift-assigned';
    }

    public function broadcastWith()
    {
        return [
            'message' => 'Shift assigned successfully.',
            'shift' => [
                'ambulance_driver_id' => $this->shift->ambulance_driver_id,
                'ambulance_service_id' => $this->shift->ambulance_service_id,
                'shift_date' => $this->shift->shift_date,
                'start_time' => $this->shift->start_time,
                'end_time' => $this->shift->end_time,
                'shift_type' => $this->shift->shift_type,
                'notes' => $this->shift->notes,
                'user_id' => $this->shift->user_id,
                'updated_at' => $this->shift->updated_at,
                'created_at' => $this->shift->created_at,
                'id' => $this->shift->id
            ]
        ];
    }
}
