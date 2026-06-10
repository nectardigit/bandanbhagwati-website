<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('author')
                    ->required()
                    ->default('Bandhan Nirman'),
                FileManagerPicker::make('cover_image')
                    ->label('Cover image'),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                RichEditor::make('body')
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->default(now()),
                Toggle::make('is_published')
                    ->default(true),
            ]);
    }
}
