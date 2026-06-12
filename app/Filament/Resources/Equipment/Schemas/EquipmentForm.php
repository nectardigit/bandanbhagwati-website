<?php

namespace App\Filament\Resources\Equipment\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('title')->label('Card heading'),
                TextInput::make('price')->label('Rental price')->placeholder('e.g. Rs. 15,000 / day'),
                TextInput::make('rating')->label('Rating (0–5)')->numeric()->minValue(0)->maxValue(5)->step(0.1)->placeholder('4.8')->helperText('Shown on the rental page. Blank = 4.8'),
                TextInput::make('reviews_label')->label('Reviews label')->placeholder('5k')->helperText('Shown as "… + Review". Blank = 5k'),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileManagerPicker::make('image')
                    ->label('Main image'),
                Repeater::make('specs')
                    ->label('Specifications')
                    ->schema([
                        TextInput::make('label')->required(),
                        TextInput::make('value')->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->default([]),
                FileManagerPicker::make('gallery')
                    ->label('Gallery')
                    ->multiple()
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
