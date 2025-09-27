<?php

namespace App\Observers;

use App\Models\Lot;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;
use Spatie\Prometheus\Facades\Prometheus;

class LotObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Lot $lot): void
    {
        Prometheus::addCounter('lots_created_total')->inc();
    }

    public function updated(Lot $lot): void
    {
        $this->clearLotCache($lot);
    }

    public function deleted(Lot $lot): void
    {
        $this->clearLotCache($lot);
    }

    protected function clearLotCache(Lot $lot): void
    {
        Cache::forget('lots.'.$lot->id);
    }
}
