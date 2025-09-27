<?php

namespace App\Observers;

use App\Models\Auction;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;
use Spatie\Prometheus\Facades\Prometheus;

class AuctionObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Auction $auction): void
    {
        $this->clearAuctionsCache();
        Prometheus::addCounter('auctions_created_total')->inc();
    }

    public function updated(Auction $auction): void
    {
        $this->clearAuctionCache($auction);
    }

    public function deleted(Auction $auction): void
    {
        $this->clearAuctionsCache();
        $this->clearAuctionCache($auction);
    }

    protected function clearAuctionsCache(): void
    {
        Cache::forget('auctions');
    }

    protected function clearAuctionCache(Auction $auction): void
    {
        Cache::forget('auctions.'.$auction->id);
    }
}
