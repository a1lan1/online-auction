<?php

namespace Database\Seeders;

use App\Enums\LotStatus;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = User::all();

        Auction::factory(15)
            ->create(['user_id' => $users->random()->id])
            ->each(fn (Auction $auction) => Lot::factory(9)->create([
                'auction_id' => $auction->id,
                'status' => LotStatus::ACTIVE,
            ]));
    }
}
