<?php

namespace App\Policies;

use App\Models\Lot;
use App\Models\User;

class LotPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Lot $lot): bool
    {
        return true;
    }

    /**
     * Any authenticated user can create a lot.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the lot owner can update it.
     */
    public function update(User $user, Lot $lot): bool
    {
        return $user->id === $lot->user_id;
    }

    /**
     * Only the lot owner can delete it.
     */
    public function delete(User $user, Lot $lot): bool
    {
        return $user->id === $lot->user_id;
    }

    /**
     * Only the lot owner can restore it.
     */
    public function restore(User $user, Lot $lot): bool
    {
        return $user->id === $lot->user_id;
    }

    /**
     * Only the lot owner can permanently delete it.
     */
    public function forceDelete(User $user, Lot $lot): bool
    {
        return $user->id === $lot->user_id;
    }
}
