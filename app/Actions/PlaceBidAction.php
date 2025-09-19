<?php

namespace App\Actions;

use App\Contracts\BidServiceInterface;
use App\DTOs\BidData;
use App\Events\NewBidPlaced;
use App\Models\Bid;

class PlaceBidAction
{
    public function __construct(protected BidServiceInterface $bidService) {}

    public function execute(BidData $data): Bid
    {
        $bid = $this->bidService->placeBid($data);

        $bid->load(['user', 'lot']);

        NewBidPlaced::dispatch($bid);

        return $bid;
    }
}
