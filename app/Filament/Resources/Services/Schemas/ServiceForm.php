<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('icon'),
                Textarea::make('short_description')
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->columnSpanFull(),
                FileManagerPicker::make('image')
                    ->label('Image'),
                Toggle::make('show_in_solutions')
                    ->required(),
                Toggle::make('show_in_accordion')
                    ->required(),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
