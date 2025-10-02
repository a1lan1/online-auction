<?php

namespace App\Contracts;

use App\Models\Auction;
use Illuminate\Support\Collection;

interface AuctionServiceInterface
{
    public function getAuctions(?int $limit): Collection;

    public function getAuction(Auction $auction): Auction;
}
