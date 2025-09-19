<?php

namespace App\Events;

use App\DTOs\BidEventData;
use App\Models\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBidPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Bid $bid) {}

    public function broadcastOn(): array
    {
        return [
            new Channel(
                sprintf('auctions.%s', $this->bid->lot->auction_id)
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'bid.new';
    }

    public function broadcastWith(): array
    {
        return [
            'bid' => BidEventData::fromBid($this->bid),
        ];
    }
}
