<?php

namespace App\Listeners;

use App\Events\LotFinished;
use App\Notifications\LotNotSoldNotification;
use App\Notifications\LotSoldNotification;
use App\Notifications\LotWonNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLotNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(LotFinished $event): void
    {
        $lot = $event->lot->loadMissing('winner', 'winnerBid', 'auction.owner');

        if ($lot->winner) {
            $lot->winner->notify(new LotWonNotification($lot));
            $lot->auction->owner->notify(new LotSoldNotification($lot));
        } else {
            $lot->auction->owner->notify(new LotNotSoldNotification($lot));
        }
    }
}
