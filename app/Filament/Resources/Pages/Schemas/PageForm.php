<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get, ?string $operation) {
                        if ($operation === 'create' || blank($get('slug'))) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('The page will live at /page/<slug>'),
                RichEditor::make('body')
                    ->columnSpanFull(),
                FileManagerPicker::make('banner_image')
                    ->label('Banner background image'),
                Textarea::make('meta_description')
                    ->rows(2)
                    ->maxLength(160)
                    ->columnSpanFull(),
                Toggle::make('show_banner')->default(true),
                Toggle::make('is_published')->default(true),
            ]);
    }
}
