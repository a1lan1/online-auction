<?php

namespace App\Providers;

use App\Contracts\AuctionServiceInterface;
use App\Contracts\BidServiceInterface;
use App\Contracts\LotServiceInterface;
use App\Services\AuctionService;
use App\Services\BidService;
use App\Services\LotService;
use Illuminate\Support\ServiceProvider;
use Override;

// use App\Models\Auction;
// use App\Models\Lot;
// use App\Models\Bid;
// use App\Observers\AuctionObserver;
// use App\Observers\LotObserver;
// use App\Observers\BidObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->bind(AuctionServiceInterface::class, AuctionService::class);
        $this->app->bind(LotServiceInterface::class, LotService::class);
        $this->app->bind(BidServiceInterface::class, BidService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auction::observe(AuctionObserver::class);
        // Lot::observe(LotObserver::class);
        // Bid::observe(BidObserver::class);
    }
}
