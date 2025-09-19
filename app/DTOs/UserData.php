<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
