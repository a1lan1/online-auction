<?php

namespace App\Filament\Resources\Lots\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LotInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('starting_price')
                    ->numeric(),
                TextEntry::make('current_price')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('auction.name')
                    ->label('Auction'),
                TextEntry::make('starts_at')
                    ->dateTime(),
                TextEntry::make('ends_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('winner.name')
                    ->label('Winner')
                    ->placeholder('-'),
                TextEntry::make('winning_bid_id')
                    ->numeric()
                    ->placeholder('-'),
            ]);
    }
}
