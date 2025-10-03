<?php

namespace App\Filament\Resources\Auctions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AuctionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('owner', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Owner'),
            ]);
    }
}
