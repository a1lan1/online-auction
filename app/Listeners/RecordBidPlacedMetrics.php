<?php

namespace App\Listeners;

use App\Events\NewBidPlaced;
use App\Events\RejectBidPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Prometheus\Facades\Prometheus;

class RecordBidPlacedMetrics implements ShouldQueue
{
    public function handle(NewBidPlaced|RejectBidPlaced $event): void
    {
        $labelValues = $event instanceof NewBidPlaced ? ['accepted'] : ['rejected'];

        Prometheus::addCounter('bids_total')->inc($labelValues);
    }
}
