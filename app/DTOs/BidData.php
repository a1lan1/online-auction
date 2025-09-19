<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class BidData extends Data
{
    public function __construct(
        #[Rule('exists:lots,id')]
        public int $lot_id,

        #[Rule('exists:users,id')]
        public int $user_id,

        #[Rule(['required', 'numeric', 'gt:0', 'decimal:0,2'])]
        public float $amount,
    ) {}
}
