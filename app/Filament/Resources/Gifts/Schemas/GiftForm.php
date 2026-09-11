<?php

namespace App\Filament\Resources\Gifts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invitation_id')
                    ->required()
                    ->numeric(),
                TextInput::make('provider_name')
                    ->required(),
                TextInput::make('account_number')
                    ->required(),
                TextInput::make('account_name')
                    ->required(),
                Toggle::make('is_physical_address')
                    ->required(),
            ]);
    }
}
