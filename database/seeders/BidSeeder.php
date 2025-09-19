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
            $bidsCount = random_int(1, 5);
            $lastAmount = $lot->starting_price;

            // Ensure we have enough unique users for the bids we want to create
            $biddingUsers = $users->count() >= $bidsCount
                ? $users->random($bidsCount)->unique()
                : $users->random($users->count())->unique();

            foreach ($biddingUsers as $user) {
                $lastAmount += random_int(10, 100);

                Bid::factory()->create([
                    'lot_id' => $lot->id,
                    'user_id' => $user->id,
                    'amount' => $lastAmount,
                ]);
            }

            // Update the lot's current price to the last bid amount
            if ($biddingUsers->isNotEmpty()) {
                $lot->update(['current_price' => $lastAmount]);
            }
        });
    }
}
