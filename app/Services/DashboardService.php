<?php

namespace App\Services;

use App\Contracts\DashboardServiceInterface;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardService implements DashboardServiceInterface
{
    public function getUserBids(User $user, int $page = 1, ?string $sortBy = 'ends_at', ?string $sortOrder = 'desc'): LengthAwarePaginator
    {
        $allowedSorts = ['title', 'current_price', 'ends_at'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'ends_at';
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';

        $lotIds = $user->bids()
            ->select('lot_id')
            ->distinct()
            ->pluck('lot_id');

        return Lot::with(['auction:id,name', 'bids'])
            ->whereIn('id', $lotIds)
            ->orderBy($sortBy, $sortOrder)
            ->paginate(perPage: 10, columns: ['*'], pageName: 'bids_page', page: $page);
    }

    public function getUserActionHistory(User $user, int $page = 1, ?string $sortBy = 'created_at', ?string $sortOrder = 'desc'): LengthAwarePaginator
    {
        $allowedSorts = ['amount', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'created_at';
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';

        return $user->bids()
            ->with('lot:id,title')
            ->orderBy($sortBy, $sortOrder)
            ->paginate(perPage: 10, columns: ['*'], pageName: 'history_page', page: $page);
    }
}
