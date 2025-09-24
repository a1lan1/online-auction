<?php

namespace App\Console\Commands;

use App\Actions\FinalizeLotAction;
use App\Enums\LotStatus;
use App\Models\Lot;
use Illuminate\Console\Command;
use Throwable;

class FinalizeAuctions extends Command
{
    protected $signature = 'auctions:finalize';

    protected $description = 'Finalize auction lots that have ended';

    /**
     * @throws Throwable
     */
    public function handle(FinalizeLotAction $finalizeLotAction): int
    {
        $this->info('Starting to finalize ended auctions...');

        // Looking for active lots whose time has already expired.
        $endedLots = Lot::where('status', LotStatus::ACTIVE)
            ->where('ends_at', '<=', now())
            ->with('bids')
            ->get();

        if ($endedLots->isEmpty()) {
            $this->info('No ended lots to process.');

            return self::SUCCESS;
        }

        $this->info(sprintf('Found %s lots to process.', $endedLots->count()));

        foreach ($endedLots as $lot) {
            $finalizeLotAction->execute($lot);
            $this->info(sprintf('Processed lot #%s: %s', $lot->id, $lot->title));
        }

        $this->info('All ended lots have been processed.');

        return self::SUCCESS;
    }
}
