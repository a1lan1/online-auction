<?php

namespace App\Contracts;

use App\Models\Lot;
use Illuminate\Database\Eloquent\Collection;

interface LotServiceInterface
{
    public function getLot(Lot $lot): Lot;

    public function autocompleteSearch(?string $query): Collection;
}
