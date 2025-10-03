<?php

namespace App\Filament\Resources\Auctions;

use App\Filament\Resources\Auctions\Pages\CreateAuction;
use App\Filament\Resources\Auctions\Pages\EditAuction;
use App\Filament\Resources\Auctions\Pages\ListAuctions;
use App\Filament\Resources\Auctions\Pages\ViewAuction;
use App\Filament\Resources\Auctions\Schemas\AuctionForm;
use App\Filament\Resources\Auctions\Schemas\AuctionInfolist;
use App\Filament\Resources\Auctions\Tables\AuctionsTable;
use App\Models\Auction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return AuctionForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return AuctionInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return AuctionsTable::configure($table);
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
            'index' => ListAuctions::route('/'),
            'create' => CreateAuction::route('/create'),
            'view' => ViewAuction::route('/{record}'),
            'edit' => EditAuction::route('/{record}/edit'),
        ];
    }
}
