<?php

namespace App\Services;

use App\Contracts\LotServiceInterface;
use App\Models\Lot;
use Illuminate\Support\Facades\Cache;

class LotService implements LotServiceInterface
{
    public function getLot(Lot $lot): Lot
    {
        return Cache::remember("lots.{$lot->id}", now()->addHours(2), function () use ($lot) {
            return $lot->load([
                'auction',
                'winnerBid',
                'winner:id,name',
                'bids.user:id,name',
            ]);
        });
    }
}
