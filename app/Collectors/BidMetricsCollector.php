<?php

namespace App\Collectors;

use Spatie\Prometheus\Collectors\Collector;
use Spatie\Prometheus\Facades\Prometheus;

class BidMetricsCollector implements Collector
{
    public function register(): void
    {
        Prometheus::addCounter('bids_total')
            ->label('result')
            ->helpText('Total bids placed (result: accepted/rejected)');

        Prometheus::addCounter('winning_bids_total')
            ->helpText('Total lots with a winning bid');

        Prometheus::addCounter('bid_amounts_sum')
            ->helpText('Sum of accepted bid amounts');

        Prometheus::addCounter('bid_amounts_count')
            ->helpText('Count of accepted bids for average calculation');
    }
}
