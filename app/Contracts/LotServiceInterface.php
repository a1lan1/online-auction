<?php

namespace App\Contracts;

use App\Models\Lot;

interface LotServiceInterface
{
    public function getLot(Lot $lot): Lot;
}
