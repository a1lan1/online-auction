<?php

namespace Database\Factories;

use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bid>
 */
class BidFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lot_id' => Lot::factory(),
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 5000),
        ];
    }
}
