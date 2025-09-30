<?php

namespace App\Providers;

use App\Contracts\AuctionServiceInterface;
use App\Contracts\BidServiceInterface;
use App\Contracts\DashboardServiceInterface;
use App\Contracts\LotServiceInterface;
use App\Services\AuctionService;
use App\Services\BidService;
use App\Services\DashboardService;
use App\Services\LotService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Override;

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
        $this->app->bind(DashboardServiceInterface::class, DashboardService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
