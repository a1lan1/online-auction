<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\BidData;
use App\Models\Bid;

interface BidServiceInterface
{
    public function placeBid(BidData $data): Bid;
}
