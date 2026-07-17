<?php

declare(strict_types=1);

namespace App\Actions;

use App\Contracts\BidServiceInterface;
use App\Events\LotFinished;
use App\Models\Bid;
use App\Models\Lot;
use App\States\Lot\NotSold;
use App\States\Lot\Sold;
use Illuminate\Support\Facades\DB;
use Throwable;

class FinalizeLotAction
{
    public function __construct(protected BidServiceInterface $bidService) {}

    /**
     * @throws Throwable
     */
    public function execute(Lot $lot): void
    {
        DB::transaction(function () use ($lot): void {
            // Find the last (highest) bid
            /** @var Bid|null $winningBid */
            $winningBid = $lot->bids()
                ->orderByDesc('amount')
                ->oldest()
                ->first();

            if ($winningBid) {
                $lot->update([
                    'winner_id' => $winningBid->user_id,
                    'winning_bid_id' => $winningBid->id,
                ]);

                $lot->status->transitionTo(Sold::class);
            } else {
                $lot->status->transitionTo(NotSold::class);
            }

            event(new LotFinished($lot));
        });
    }
}
