<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Random\RandomException;

class BidSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * @throws RandomException
     */
    public function run(): void
    {
        $lots = Lot::all();
        $users = User::all();

        if ($lots->isEmpty() || $users->isEmpty()) {
            $this->command->info('Cannot seed bids. Please make sure you have lots and users in the database.');

            return;
        }

        $lots->each(function (Lot $lot) use ($users) {
            $bidsCount = random_int(1, 10);
            $lastAmount = $lot->starting_price;

            // Determine the number of bidders, ensuring it doesn't exceed the available user count.
            $numberOfBidders = min($bidsCount, $users->count());
            $biddingUsers = $users->random($numberOfBidders);

            // Use iteration with an index to create chronological timestamps.
            // The values() method resets collection keys to a zero-based index (0, 1, 2...).
            $biddingUsers->values()->each(function (User $user, int $index) use ($lot, &$lastAmount, $numberOfBidders) {
                $lastAmount += random_int(10, 100);

                // Create bids in chronological order, with the last bid being the most recent.
                // Assume a 5-minute interval between bids.
                $minutesAgo = ($numberOfBidders - $index) * 5;
                $createdAt = now()->subMinutes($minutesAgo);

                $bid = Bid::factory()->make([
                    'lot_id' => $lot->id,
                    'user_id' => $user->id,
                    'amount' => $lastAmount,
                ]);

                $bid->created_at = $createdAt;
                $bid->updated_at = $createdAt;
                $bid->save();
            });

            // Update the lot's current price to the last bid amount
            if ($biddingUsers->isNotEmpty()) {
                $lot->update(['current_price' => $lastAmount]);
            }
        });
    }
}
