<?php

namespace App\Observers;

use App\Models\Bid;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;
use Spatie\Prometheus\Facades\Prometheus;

class BidObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Bid $bid): void
    {
        Cache::forget('lots.'.$bid->lot_id);

        // Observe accepted bid amount via sum+count counters
        $amount = (float) $bid->amount;

        if ($amount > 0) {
            Prometheus::addCounter('bid_amounts_sum')->inc($bid->amount);
            Prometheus::addCounter('bid_amounts_count')->inc();
        }
    }
}
