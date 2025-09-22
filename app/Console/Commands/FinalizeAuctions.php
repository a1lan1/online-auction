<?php

namespace App\Console\Commands;

use App\Actions\FinalizeLotAction;
use App\Models\Lot;
use Illuminate\Console\Command;

class FinalizeAuctions extends Command
{
    protected $signature = 'auctions:finalize';

    protected $description = 'Finalize auction lots that have ended';

    /**
     * @throws \Throwable
     */
    public function handle(FinalizeLotAction $finalizeLotAction): int
    {
        $this->info('Starting to finalize ended auctions...');

        // Looking for active lots whose time has already expired.
        $endedLots = Lot::active()
            ->where('ends_at', '<=', now())
            ->with('bids')
            ->get();

        if ($endedLots->isEmpty()) {
            $this->info('No ended lots to process.');

            return self::SUCCESS;
        }

        $this->info("Found {$endedLots->count()} lots to process.");

        foreach ($endedLots as $lot) {
            $finalizeLotAction->execute($lot);
            $this->info("Processed lot #{$lot->id}: {$lot->title}");
        }

        $this->info('All ended lots have been processed.');

        return self::SUCCESS;
    }
}
