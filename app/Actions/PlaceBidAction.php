<?php

namespace App\Actions;

use App\Contracts\BidServiceInterface;
use App\DTOs\BidData;
use App\Events\NewBidPlaced;
use App\Events\RejectBidPlaced;
use App\Models\Bid;
use Throwable;

class PlaceBidAction
{
    public function __construct(protected BidServiceInterface $bidService) {}

    /**
     * @throws Throwable
     */
    public function execute(BidData $data): Bid
    {
        try {
            $bid = $this->bidService->placeBid($data);

            $bid->load(['user', 'lot']);

            NewBidPlaced::dispatch($bid);
        } catch (Throwable $throwable) {
            RejectBidPlaced::dispatch($data);

            throw $throwable;
        }

        return $bid;
    }
}
