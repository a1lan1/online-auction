<?php

namespace App\Events;

use App\DTOs\BidData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RejectBidPlaced implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public readonly BidData $bidData) {}

    public function broadcastOn(): array
    {
        return [
            new Channel(
                sprintf('user.%s', $this->bidData->user_id)
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'bid.reject';
    }
}
