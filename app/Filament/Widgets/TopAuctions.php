<?php

namespace App\Filament\Widgets;

use App\Models\Auction;
use Filament\Widgets\ChartWidget;
use Override;

class TopAuctions extends ChartWidget
{
    protected ?string $heading = 'Top 5 Auctions by Lot Count';

    #[Override]
    protected function getData(): array
    {
        $data = Auction::withCount('lots')
            ->orderByDesc('lots_count')
            ->limit(5)
            ->pluck('lots_count', 'name');

        $colors = [
            '#4CAF50',
            '#36A2EB',
            '#FFCE56',
            '#FF6384',
            '#9966FF',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Number of Lots',
                    'data' => $data->values()->all(),
                    'backgroundColor' => array_slice($colors, 0, $data->count()),
                    'borderColor' => array_slice($colors, 0, $data->count()),
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->keys()->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
