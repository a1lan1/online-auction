<?php

namespace App\Events;

use App\Models\Lot;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LotFinished implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public readonly Lot $lot)
    {
        $this->lot->loadMissing([
            'auction',
            'winnerBid',
            'winner:id,name',
            'bids.user:id,name',
        ]);
    }

    public function broadcastOn(): array
    {
        return [
            new Channel(
                sprintf('auctions.%s', $this->lot->auction_id)
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'lot.finished';
    }

    public function broadcastWith(): array
    {
        return [
            'lot' => $this->lot,
        ];
    }
}
