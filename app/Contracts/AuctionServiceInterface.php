<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Auction;
use Illuminate\Support\Collection;

interface AuctionServiceInterface
{
    public function getAuctions(?int $limit): Collection;

    public function getAuction(Auction $auction): Auction;
}
