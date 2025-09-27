<?php

namespace App\Listeners;

use App\Events\LotFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Prometheus\Facades\Prometheus;

class RecordLotFinishedMetrics implements ShouldQueue
{
    public function handle(LotFinished $event): void
    {
        $lot = $event->lot;
        $result = $lot->winner_id ? 'sold' : 'unsold';

        Prometheus::addCounter('lots_finished_total')->inc(1, [$result]);

        if ($lot->winner_id) {
            Prometheus::addCounter('winning_bids_total')->inc();
        }

        $duration = max(0, $lot->ends_at->diffInSeconds($lot->starts_at));

        Prometheus::addCounter('lot_lifecycle_duration_seconds_sum')->inc($duration);
        Prometheus::addCounter('lot_lifecycle_duration_seconds_count')->inc();
    }
}
