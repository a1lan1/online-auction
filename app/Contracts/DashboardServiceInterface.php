<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface DashboardServiceInterface
{
    public function getUserBids(User $user, int $page, ?string $sortBy, ?string $sortOrder): LengthAwarePaginator;

    public function getUserActionHistory(User $user, int $page, ?string $sortBy, ?string $sortOrder): LengthAwarePaginator;
}
