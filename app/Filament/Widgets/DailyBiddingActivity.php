<?php

namespace App\Filament\Widgets;

use App\Models\Bid;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Override;

class DailyBiddingActivity extends ChartWidget
{
    protected ?string $heading = 'Daily Bidding Activity';

    #[Override]
    protected function getData(): array
    {
        $data = Trend::model(Bid::class)
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Bids Placed',
                    'data' => $data->map(fn (TrendValue $value): mixed => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value): string => $value->date),
            'backgroundColor' => '#36A2EB',
            'borderColor' => '#9BD0F5',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
