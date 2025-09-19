<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('production')) {
            $this->call([
                UserSeeder::class,
                AuctionSeeder::class,
                BidSeeder::class,
            ]);
        }
    }
}
