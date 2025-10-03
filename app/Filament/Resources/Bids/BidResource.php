<?php

namespace App\Filament\Resources\Bids;

use App\Filament\Resources\Bids\Pages\ListBids;
use App\Filament\Resources\Bids\Pages\ViewBid;
use App\Filament\Resources\Bids\Schemas\BidForm;
use App\Filament\Resources\Bids\Schemas\BidInfolist;
use App\Filament\Resources\Bids\Tables\BidsTable;
use App\Models\Bid;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

class BidResource extends Resource
{
    protected static ?string $model = Bid::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return BidForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return BidInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return BidsTable::configure($table);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBids::route('/'),
            'view' => ViewBid::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
