<?php

namespace App\Collectors;

use Spatie\Prometheus\Collectors\Collector;
use Spatie\Prometheus\Facades\Prometheus;

class AuctionMetricsCollector implements Collector
{
    public function register(): void
    {
        // Auction domain metrics
        Prometheus::addCounter('auctions_created_total')
            ->helpText('Total auctions created');

        Prometheus::addCounter('lots_created_total')
            ->helpText('Total lots created');

        Prometheus::addCounter('lots_finished_total')
            ->label('result') // sold|unsold
            ->helpText('Total lots finished grouped by result');

        Prometheus::addCounter('lot_lifecycle_duration_seconds_sum')
            ->helpText('Sum of lot lifecycle durations in seconds');

        Prometheus::addCounter('lot_lifecycle_duration_seconds_count')
            ->helpText('Count of finished lots for lifecycle duration calculation');
    }
}
