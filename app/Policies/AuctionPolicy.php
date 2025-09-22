<?php

namespace App\Policies;

use App\Models\Auction;
use App\Models\User;

class AuctionPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Auction $auction): bool
    {
        return true;
    }

    /**
     * Only the lot owner can update the auction details.
     */
    public function update(User $user, Auction $auction): bool
    {
        return $user->id === $auction->user_id;
    }

    /**
     * The owner can delete the auction.
     */
    public function delete(User $user, Auction $auction): bool
    {
        return $user->id === $auction->user_id;
    }
}
