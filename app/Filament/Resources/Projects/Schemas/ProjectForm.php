<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
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
                Select::make('project_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')->required(),
                    ])
                    ->editOptionForm([
                        TextInput::make('name')->required(),
                        TextInput::make('slug')->required(),
                    ])
                    ->helperText('Pick a category, or create/edit one inline. Manage all categories under "Project Categories".'),
                TextInput::make('caption')->label('Card label (small text)')->default('Building'),
                Select::make('client')
                    ->options(fn () => \App\Models\Project::query()->whereNotNull('client')->where('client', '!=', '')->distinct()->orderBy('client')->pluck('client', 'client')->all())
                    ->searchable()
                    ->native(false)
                    ->createOptionForm([TextInput::make('client')->label('New client')->required()])
                    ->createOptionUsing(fn (array $data) => $data['client']),
                Select::make('status')
                    ->options(['ongoing' => 'Ongoing', 'completed' => 'Completed'])
                    ->default('ongoing')
                    ->required(),
                FileManagerPicker::make('cover_image')
                    ->label('Cover image'),
                RichEditor::make('body')
                    ->columnSpanFull(),
                TextInput::make('progress')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%'),
                Repeater::make('specs')
                    ->schema([
                        TextInput::make('label')->required(),
                        TextInput::make('value')->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->default([]),
                Repeater::make('features')
                    ->schema([
                        TextInput::make('icon')->label('Icon (emoji)')->default('🏗️'),
                        TextInput::make('title')->required(),
                        TextInput::make('text'),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->default([]),
                FileManagerPicker::make('gallery')
                    ->label('Gallery')
                    ->multiple()
                    ->columnSpanFull(),
                Toggle::make('is_featured')->label('Show on home page'),
                TextInput::make('sort')->required()->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]);
    }
}
