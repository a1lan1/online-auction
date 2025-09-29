<?php

namespace App\Services;

use App\Contracts\LotServiceInterface;
use App\Models\Lot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class LotService implements LotServiceInterface
{
    private const int AUTOCOMPLETE_LIMIT = 10;

    public function getLot(Lot $lot): Lot
    {
        return Cache::remember('lots.'.$lot->id, now()->addHours(2), function () use ($lot) {
            return $lot->load([
                'auction',
                'winnerBid',
                'winner:id,name',
                'bids.user:id,name',
            ]);
        });
    }

    public function autocompleteSearch(?string $query): Collection
    {
        if (blank($query)) {
            return new Collection;
        }

        return Lot::search($query)
            ->take(self::AUTOCOMPLETE_LIMIT)
            ->get();
    }
}
