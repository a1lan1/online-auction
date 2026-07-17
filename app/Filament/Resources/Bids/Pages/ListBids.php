<?php

declare(strict_types=1);

namespace App\Filament\Resources\Bids\Pages;

use App\Filament\Resources\Bids\BidResource;
use Filament\Resources\Pages\ListRecords;
use Override;

class ListBids extends ListRecords
{
    protected static string $resource = BidResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [];
    }
}
