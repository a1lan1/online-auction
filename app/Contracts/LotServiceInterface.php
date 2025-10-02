<?php

namespace App\Contracts;

use App\Models\Lot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface LotServiceInterface
{
    public function getLot(Lot $lot): Lot;

    public function getLots(int $auctionId): LengthAwarePaginator;

    public function autocompleteSearch(?string $query): Collection;
}
