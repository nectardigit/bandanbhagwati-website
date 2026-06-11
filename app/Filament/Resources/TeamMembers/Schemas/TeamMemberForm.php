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
                TextInput::make('department')
                    ->datalist(fn () => \App\Models\TeamMember::query()->whereNotNull('department')->distinct()->pluck('department')->all())
                    ->helperText('Members are grouped under this heading on the Team page (e.g. Board of Directors, Technical Team).'),
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
