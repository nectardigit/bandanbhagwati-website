<?php

namespace App\Filament\Resources\VideoAlbums\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class VideoAlbumForm
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
                ->label('Album cover (optional)'),
            Repeater::make('videos')
                ->label('Videos in this album')
                ->columnSpanFull()
                ->schema([
                    TextInput::make('title')->label('Video title'),
                    TextInput::make('url')
                        ->label('Video URL (YouTube, Vimeo, or .mp4 link)')
                        ->required()
                        ->placeholder('https://www.youtube.com/watch?v=...'),
                    FileManagerPicker::make('thumb')->label('Thumbnail (optional — auto for YouTube)'),
                ])
                ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Video')
                ->collapsible()
                ->addActionLabel('Add video')
                ->default([]),
            TextInput::make('sort')
                ->numeric()
                ->default(0),
            Toggle::make('is_active')
                ->default(true),
        ]);
    }
}
