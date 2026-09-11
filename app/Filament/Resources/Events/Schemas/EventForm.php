<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invitation_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                DateTimePicker::make('start_time')
                    ->required(),
                DateTimePicker::make('end_time'),
                TextInput::make('timezone')
                    ->required()
                    ->default('WIB'),
                TextInput::make('location_name')
                    ->required(),
                Textarea::make('location_address')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('google_maps_url')
                    ->columnSpanFull(),
            ]);
    }
}
