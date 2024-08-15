<?php

namespace App\Events;

use App\Models\PendaftaranMagangModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AcceptanceStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $pendaftaran;
    /**
     * Create a new event instance.
     */
    // public function __construct(PendaftaranMagangModel $pendaftaran)
    // {
    //     $this->pendaftaran = $pendaftaran;
    // }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
