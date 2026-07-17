<?php

namespace App\Filament\Widgets;

use App\Models\Lot;
use App\States\Lot\Active;
use App\States\Lot\Cancelled;
use App\States\Lot\NotSold;
use App\States\Lot\Pending;
use App\States\Lot\Sold;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Override;

class LotStatusDistribution extends ChartWidget
{
    protected ?string $heading = 'Lot Status Distribution';

    #[Override]
    protected function getData(): array
    {
        $statusCounts = Lot::query()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $data = [];
        $labels = [];
        $colors = [];

        $colorMap = [
            'pending' => '#FFED85',
            'active' => '#36A2EB',
            'sold' => '#4CAF50',
            'not_sold' => '#FF9800',
            'cancelled' => '#FF6384',
        ];

        $states = [
            Pending::$name,
            Active::$name,
            Sold::$name,
            NotSold::$name,
            Cancelled::$name,
        ];

        foreach ($states as $status) {
            $data[] = $statusCounts->get($status, 0);
            $labels[] = ucfirst(str_replace('_', ' ', $status));
            $colors[] = $colorMap[$status];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Lots',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
