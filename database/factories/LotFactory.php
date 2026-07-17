<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Lot;
use App\States\Lot\Active;
use App\States\Lot\NotSold;
use App\States\Lot\Sold;
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
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'starts_at' => now()->subDays(5),
            'ends_at' => fake()->dateTimeBetween('-2 days', '+5 days'),
            'starting_price' => fake()->randomFloat(2, 100, 1000),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Active::class,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
        ]);
    }

    public function sold(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Sold::class,
            'starts_at' => now()->subDays(2),
            'ends_at' => now()->subDay(),
        ]);
    }

    public function notSold(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => NotSold::class,
            'starts_at' => now()->subDays(2),
            'ends_at' => now()->subDay(),
        ]);
    }
}
