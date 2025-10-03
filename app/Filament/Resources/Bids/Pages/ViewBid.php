<?php

namespace App\Filament\Resources\Bids\Pages;

use App\Filament\Resources\Bids\BidResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBid extends ViewRecord
{
    protected static string $resource = BidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
