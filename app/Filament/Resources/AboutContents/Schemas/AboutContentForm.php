<?php

namespace App\Filament\Resources\AboutContents\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('About section')
                    ->columns(2)
                    ->schema([
                        TextInput::make('banner_title')->label('Page banner title')->default('About Us'),
                        TextInput::make('eyebrow')->default('About'),
                        TextInput::make('heading')->label('Heading')->columnSpanFull(),
                        Repeater::make('features')
                            ->label('Feature rows')
                            ->schema([
                                TextInput::make('title')->required(),
                                Textarea::make('text')->rows(2),
                            ])
                            ->maxItems(4)
                            ->columnSpanFull()
                            ->default([]),
                        TextInput::make('card_one')->label('Card 1 text'),
                        TextInput::make('card_two')->label('Card 2 text'),
                        TextInput::make('years_label')->label('Badge title')->default('10+ years'),
                        TextInput::make('years_sub')->label('Badge subtitle')->default('of experience'),
                        TextInput::make('explore_url')->label('"Explore now" link')->default('/service'),
                    ]),

                Section::make('Images (pick from File Manager)')
                    ->columns(2)
                    ->schema([
                        FileManagerPicker::make('photo1')->label('Engineers photo'),
                        FileManagerPicker::make('photo2')->label('City photo'),
                        FileManagerPicker::make('badge_image')->label('"10+ years" badge image'),
                        FileManagerPicker::make('cone_image')->label('Under-construction image'),
                        FileManagerPicker::make('banner_image')->label('Page banner background'),
                        FileManagerPicker::make('service_image')->label('Services card image'),
                        FileManagerPicker::make('faq_image')->label('FAQ section image'),
                    ]),

                Section::make('Contact CTA block')
                    ->columns(2)
                    ->schema([
                        TextInput::make('cta_eyebrow')->label('Eyebrow'),
                        TextInput::make('cta_heading')->label('Heading'),
                        Textarea::make('cta_text')->label('Text')->rows(3)->columnSpanFull(),
                    ]),
            ]);
    }
}
