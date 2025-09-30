<?php

namespace App\Http\Controllers;

use App\Contracts\DashboardServiceInterface;
use App\Http\Resources\ActionHistoryCollection;
use App\Http\Resources\DashboardLotCollection;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardServiceInterface $dashboardService) {}

    public function index(): Response
    {
        $user = request()->user();

        $myBids = $this->dashboardService->getUserBids(
            user: $user,
            page: (int) request()->query('bids_page', 1),
            sortBy: request()->query('bids_sort_by'),
            sortOrder: request()->query('bids_sort_order')
        );

        $actionHistory = $this->dashboardService->getUserActionHistory(
            user: $user,
            page: (int) request()->query('history_page', 1),
            sortBy: request()->query('history_sort_by'),
            sortOrder: request()->query('history_sort_order')
        );

        return Inertia::render('Dashboard', [
            'myBids' => new DashboardLotCollection($myBids),
            'actionHistory' => new ActionHistoryCollection($actionHistory),
        ]);
    }
}
