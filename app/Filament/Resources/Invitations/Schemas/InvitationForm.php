<?php

namespace App\Filament\Resources\Invitations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InvitationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                TextInput::make('theme')
                    ->required()
                    ->default('tema-satu'),
                TextInput::make('groom_nickname')
                    ->required(),
                TextInput::make('groom_fullname')
                    ->required(),
                TextInput::make('groom_father')
                    ->required(),
                TextInput::make('groom_mother')
                    ->required(),
                TextInput::make('groom_instagram'),
                TextInput::make('bride_nickname')
                    ->required(),
                TextInput::make('bride_fullname')
                    ->required(),
                TextInput::make('bride_father')
                    ->required(),
                TextInput::make('bride_mother')
                    ->required(),
                TextInput::make('bride_instagram'),
                FileUpload::make('cover_image')
                    ->image(),
                TextInput::make('background_music'),
                Textarea::make('quote')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
