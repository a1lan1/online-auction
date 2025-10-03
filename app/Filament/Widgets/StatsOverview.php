<?php

namespace App\Filament\Widgets;

use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Override;

class StatsOverview extends BaseWidget
{
    #[Override]
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All users in the system')
                ->color('success'),
            Stat::make('Active Lots', Lot::active()->count())
                ->description('Lots currently open for bidding')
                ->color('warning'),
            Stat::make('Total Bids', Bid::count())
                ->description('All bids placed')
                ->color('info'),
        ];
    }
}
