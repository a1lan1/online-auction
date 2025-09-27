<?php

namespace App\Console\Commands;

use App\Actions\PlaceBidAction;
use App\DTOs\BidData;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Console\Command;
use Throwable;

class PlaceRandomBidCommand extends Command
{
    protected $signature = 'auctions:place-bid';

    protected $description = 'Place a random bid by a random user on a random lot (for demo & metrics)';

    public function handle(PlaceBidAction $action): int
    {
        $user = User::inRandomOrder()->first();
        $lot = Lot::query()->inRandomOrder()->first();

        if (! $lot || ! $user) {
            $this->error('No lot or user found to bid on.');

            return self::FAILURE;
        }

        $price = $lot->current_price ?? (float) $lot->starting_price;

        $amount = $price + 50;

        try {
            $action->execute(new BidData(
                lot_id: $lot->id,
                user_id: $user->id,
                amount: $amount,
            ));

            $this->info(sprintf('Accepted bid: lot #%d by user #%d amount=%.2f', $lot->id, $user->id, $amount));
        } catch (Throwable $throwable) {
            $this->warn(sprintf('Rejected bid: lot #%d by user #%d amount=%.2f (%s)', $lot->id, $user->id, $amount, $throwable->getMessage()));
        }

        return self::SUCCESS;
    }
}
