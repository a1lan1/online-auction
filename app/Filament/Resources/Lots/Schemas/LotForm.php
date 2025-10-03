<?php

namespace App\Filament\Resources\Lots\Schemas;

use App\Enums\LotStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Main Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Select::make('auction_id')
                            ->relationship('auction', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->options(LotStatus::class)
                            ->required(),
                    ]),
                Section::make('Pricing and Dates')
                    ->columns(2)
                    ->components([
                        TextInput::make('starting_price')
                            ->required()
                            ->numeric()
                            ->prefix('USD'),
                        DateTimePicker::make('starts_at')
                            ->required(),
                        DateTimePicker::make('ends_at')
                            ->required(),
                    ]),
                Section::make('Images')
                    ->columns(2)
                    ->components([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->collection('lot.image')
                            ->label('Main Image')
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->collection('lot.gallery')
                            ->multiple()
                            ->reorderable()
                            ->label('Gallery'),
                    ]),
            ]);
    }
}
