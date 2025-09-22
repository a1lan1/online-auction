<?php

namespace App\Services;

use App\Contracts\BidServiceInterface;
use App\DTOs\BidData;
use App\Exceptions\AuctionEndedException;
use App\Exceptions\BidTooLowException;
use App\Exceptions\UserIsLeadingException;
use App\Models\Bid;
use App\Models\Lot;
use Illuminate\Support\Facades\DB;

class BidService implements BidServiceInterface
{
    /**
     * @throws \Throwable
     */
    public function placeBid(BidData $data): Bid
    {
        return DB::transaction(function () use ($data) {
            // Lock the lot for update to prevent race conditions.
            $lot = Lot::lockForUpdate()->findOrFail($data->lot_id);

            // 1. Validate auction status
            if ($lot->ends_at->isPast()) {
                throw new AuctionEndedException('This auction has already ended.');
            }

            // 2. Validate bid amount
            if ($data->amount <= $lot->current_price) {
                throw new BidTooLowException('Your bid must be higher than the current price.');
            }

            // 3. Check if the user is already the highest bidder
            /** @var Bid|null $lastBid */
            $lastBid = $lot->bids()->latest()->first();
            if ($lastBid && $lastBid->user_id === $data->user_id) {
                throw new UserIsLeadingException('You are already the highest bidder.');
            }

            /** @var Bid $bid */
            $bid = $lot->bids()->create([
                'user_id' => $data->user_id,
                'amount' => $data->amount,
            ]);

            $lot->update(['current_price' => $data->amount]);

            return $bid;
        }, 5); // Retry up to 5 times in case of deadlock
    }
}
