<?php

namespace Database\Seeders;

use App\Enums\LotStatus;
use App\Models\Auction;
use App\Models\Lot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $imgUrl = 'https://picsum.photos/800/600';

        Auction::factory(15)
            ->create()
            ->each(function (Auction $auction) use ($imgUrl): void {
                Lot::factory(random_int(3, 6))
                    ->afterCreating(function (Lot $lot) use ($imgUrl): void {
                        $lot->addMediaFromUrl($imgUrl)
                            ->toMediaCollection('lot.image');

                        for ($j = 1; $j <= random_int(3, 6); $j++) {
                            $lot->addMediaFromUrl($imgUrl)
                                ->toMediaCollection('lot.gallery');
                        }
                    })
                    ->create([
                        'auction_id' => $auction->id,
                        'status' => LotStatus::ACTIVE,
                    ]);
            });
    }
}
