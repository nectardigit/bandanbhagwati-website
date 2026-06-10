<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('role'),
                FileManagerPicker::make('photo')
                    ->label('Photo'),
                TextInput::make('facebook'),
                TextInput::make('instagram'),
                TextInput::make('twitter'),
                TextInput::make('linkedin'),
                TextInput::make('youtube'),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
