<?php

namespace App\Collectors;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;
use Spatie\Prometheus\Collectors\Collector;
use Spatie\Prometheus\Facades\Prometheus;

class ModelCountCollector implements Collector
{
    public function register(): void
    {
        Prometheus::addGauge('User count')
            ->name('user_count')
            ->helpText('The total number of users.')
            ->value(fn () => User::count());

        Prometheus::addGauge('Auction count')
            ->name('auction_count')
            ->helpText('The total number of auctions.')
            ->value(fn () => Auction::count());

        Prometheus::addGauge('Lot count')
            ->name('lot_count')
            ->helpText('The total number of lots.')
            ->value(fn () => Lot::count());

        Prometheus::addGauge('Bid count')
            ->name('bid_count')
            ->helpText('The total number of bids.')
            ->value(fn () => Bid::count());
    }
}
