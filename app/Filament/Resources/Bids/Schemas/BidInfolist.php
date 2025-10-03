<?php

namespace App\Filament\Resources\Bids\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BidInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('lot.title')
                    ->label('Lot'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
