<?php

namespace App\DTOs;

use App\Models\Bid;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class BidEventData extends Data
{
    public function __construct(
        public int $id,
        public int $lot_id,
        public int $user_id,
        public float $amount,
        public ?CarbonImmutable $created_at,
        public UserData $user,
    ) {}

    public static function fromBid(Bid $bid): self
    {
        return new self(
            id: $bid->id,
            lot_id: $bid->lot_id,
            user_id: $bid->user_id,
            amount: $bid->amount,
            created_at: $bid->created_at ? CarbonImmutable::parse($bid->created_at) : null,
            user: UserData::from($bid->user),
        );
    }
}
