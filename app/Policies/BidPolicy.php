<?php

namespace App\Policies;

use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;

class BidPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Bid $bid): bool
    {
        return true;
    }

    /**
     * A user cannot bid on their own lot.
     * A user can only bid if the lot is active.
     */
    public function create(User $user, Lot $lot): bool
    {
        return $user->id !== $lot->auction->user_id
            && now()->between($lot->starts_at, $lot->ends_at);
    }

    /**
     * Bids are immutable and cannot be updated.
     */
    public function update(User $user, Bid $bid): bool
    {
        return false;
    }

    /**
     * Bids cannot be deleted (retracted).
     */
    public function delete(User $user, Bid $bid): bool
    {
        return false;
    }
}
