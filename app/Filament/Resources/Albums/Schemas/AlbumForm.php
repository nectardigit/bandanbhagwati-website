<?php

namespace App\Filament\Resources\Albums\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Textarea::make('description')
                ->rows(2)
                ->columnSpanFull(),
            FileManagerPicker::make('cover')
                ->label('Album cover (optional — defaults to the first photo)'),
            FileManagerPicker::make('images')
                ->label('Photos in this album')
                ->multiple()
                ->columnSpanFull(),
            TextInput::make('sort')
                ->numeric()
                ->default(0),
            Toggle::make('is_active')
                ->default(true),
        ]);
    }
}
