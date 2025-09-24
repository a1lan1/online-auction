<?php

namespace App\Observers;

use App\Models\Bid;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;

class BidObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Bid $bid): void
    {
        Cache::forget('lots.'.$bid->lot_id);
    }
}
