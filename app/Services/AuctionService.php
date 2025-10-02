<?php

namespace App\Services;

use App\Contracts\AuctionServiceInterface;
use App\Models\Auction;
use App\Models\Lot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AuctionService implements AuctionServiceInterface
{
    public function getAuctions(?int $limit = 30): Collection
    {
        return Cache::remember('auctions', now()->addHours(2), function () use ($limit) {
            return Auction::query()
                ->with('owner:id,name')
                ->withCount(['lots' => function (Builder $query) {
                    /** @var Builder<Lot> $query */
                    return $query->active();
                }])
                ->limit($limit)
                ->get();
        });
    }

    public function getAuction(Auction $auction): Auction
    {
        return Cache::remember('auctions.'.$auction->id, now()->addHours(2), function () use ($auction) {
            return $auction->load(['owner:id,name']);
        });
    }
}
