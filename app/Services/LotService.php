<?php

namespace App\Services;

use App\Contracts\LotServiceInterface;
use App\Models\Lot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class LotService implements LotServiceInterface
{
    private const int LOTS_PAGINATE = 8;

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

    public function getLots(int $auctionId): LengthAwarePaginator
    {
        return Lot::where('auction_id', $auctionId)
            ->active()
            ->finished()
            ->withCount('bids')
            ->with('winner:id,name')
            ->orderBy('status')
            ->orderByDesc('created_at')
            ->paginate(self::LOTS_PAGINATE);
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
