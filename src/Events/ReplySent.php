<?php

namespace LaraZeus\Wind\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaraZeus\Wind\Models\Letter;

class ReplySent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Letter $letter;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Letter $letter)
    {
        $this->letter = $letter;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel | PrivateChannel | array
    {
        return new PrivateChannel('zeus-wind');
    }
}
