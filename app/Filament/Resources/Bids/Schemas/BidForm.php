<?php

namespace App\Filament\Resources\Bids\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BidForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lot_id')
                    ->relationship('lot', 'title')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
