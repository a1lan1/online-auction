<?php

namespace App\Events;

use App\Contracts\LotServiceInterface;
use App\Models\Lot;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LotFinished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Lot $lot) {}

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

    public function broadcastWith(LotServiceInterface $lotService): array
    {
        return [
            'lot' => $lotService->getLot($this->lot),
        ];
    }
}
