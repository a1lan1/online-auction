<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Lot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lot>
 */
class LotFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auction_id' => Auction::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'starting_price' => $this->faker->randomFloat(2, 100, 1000),
            'current_price' => 0,
        ];
    }
}
