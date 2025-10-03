<?php

namespace App\Filament\Widgets;

use App\Enums\LotStatus;
use App\Models\Lot;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Override;

class LotStatusDistribution extends ChartWidget
{
    protected ?string $heading = 'Lot Status Distribution';

    #[Override]
    protected function getData(): array
    {
        $allStatuses = LotStatus::cases();
        $statusCounts = Lot::query()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $data = [];
        $labels = [];
        $colors = [];

        $colorMap = [
            LotStatus::PENDING->value => '#FFED85',
            LotStatus::ACTIVE->value => '#36A2EB',
            LotStatus::FINISHED->value => '#4CAF50',
            LotStatus::CANCELED->value => '#FF6384',
        ];

        foreach ($allStatuses as $status) {
            $data[] = $statusCounts->get($status->value, 0);
            $labels[] = $status->name;
            $colors[] = $colorMap[$status->value];
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
