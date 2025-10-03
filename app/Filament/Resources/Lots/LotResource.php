<?php

namespace App\Filament\Resources\Lots;

use App\Filament\Resources\Lots\Pages\CreateLot;
use App\Filament\Resources\Lots\Pages\EditLot;
use App\Filament\Resources\Lots\Pages\ListLots;
use App\Filament\Resources\Lots\Pages\ViewLot;
use App\Filament\Resources\Lots\Schemas\LotForm;
use App\Filament\Resources\Lots\Schemas\LotInfolist;
use App\Filament\Resources\Lots\Tables\LotsTable;
use App\Models\Lot;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

class LotResource extends Resource
{
    protected static ?string $model = Lot::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return LotForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return LotInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return LotsTable::configure($table);
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
            'index' => ListLots::route('/'),
            'create' => CreateLot::route('/create'),
            'view' => ViewLot::route('/{record}'),
            'edit' => EditLot::route('/{record}/edit'),
        ];
    }
}
