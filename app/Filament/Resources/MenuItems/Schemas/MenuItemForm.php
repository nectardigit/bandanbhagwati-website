<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->required(),

                Select::make('type')
                    ->required()
                    ->default('link')
                    ->live()
                    ->native(false)
                    ->options([
                        'link' => 'Custom link (enter a URL)',
                        'page' => 'Page (create / pick a page)',
                    ]),

                // --- Custom link ---
                TextInput::make('url')
                    ->label('URL')
                    ->default('#')
                    ->helperText('A path like /about or a full URL like https://…')
                    ->visible(fn ($get) => $get('type') === 'link')
                    ->required(fn ($get) => $get('type') === 'link'),

                // --- Page: write the content here; saving creates/updates a page named after the Label ---
                RichEditor::make('page_content')
                    ->label('Page content')
                    ->visible(fn ($get) => $get('type') === 'page')
                    ->required(fn ($get) => $get('type') === 'page')
                    ->columnSpanFull()
                    ->helperText('This is shown on the page. The menu “Label” above is used as the page title, and the URL is /<slug-of-label>.'),

                Select::make('location')
                    ->required()
                    ->default('header')
                    ->native(false)
                    ->options([
                        'header'         => 'Header navigation',
                        'footer_company' => 'Footer — Company column',
                        'footer_quick'   => 'Footer — Quick Links column',
                    ]),

                Select::make('parent_id')
                    ->label('Parent (for header dropdown items)')
                    ->relationship('parent', 'label', fn ($query) => $query->where('location', 'header')->whereNull('parent_id'))
                    ->searchable()
                    ->preload()
                    ->placeholder('— none (top level) —'),

                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first.'),

                Toggle::make('open_new_tab'),
                Toggle::make('is_active')->default(true),
            ]);
    }
}
