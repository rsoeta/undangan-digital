<?php

namespace App\Filament\Resources\Rsvps\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RsvpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invitation_id')
                    ->required()
                    ->numeric(),
                TextInput::make('guest_name')
                    ->required(),
                Select::make('attendance')
                    ->options(['hadir' => 'Hadir', 'tidak_hadir' => 'Tidak hadir', 'ragu' => 'Ragu'])
                    ->required(),
                TextInput::make('guest_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
