<?php

namespace App\Providers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Lot;
use App\Policies\AuctionPolicy;
use App\Policies\BidPolicy;
use App\Policies\LotPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Lot::class => LotPolicy::class,
        Bid::class => BidPolicy::class,
        Auction::class => AuctionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
