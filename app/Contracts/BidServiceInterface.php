<?php

namespace App\Contracts;

use App\DTOs\BidData;
use App\Models\Bid;

interface BidServiceInterface
{
    public function placeBid(BidData $data): Bid;
}
