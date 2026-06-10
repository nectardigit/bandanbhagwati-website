<?php

namespace App\Filament\Resources\AboutContents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutContentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('banner_title')
                    ->searchable(),
                TextColumn::make('eyebrow')
                    ->searchable(),
                TextColumn::make('heading')
                    ->searchable(),
                TextColumn::make('card_one')
                    ->searchable(),
                TextColumn::make('card_two')
                    ->searchable(),
                TextColumn::make('years_label')
                    ->searchable(),
                TextColumn::make('years_sub')
                    ->searchable(),
                TextColumn::make('explore_url')
                    ->searchable(),
                TextColumn::make('cta_eyebrow')
                    ->searchable(),
                TextColumn::make('cta_heading')
                    ->searchable(),
                TextColumn::make('photo1')
                    ->searchable(),
                TextColumn::make('photo2')
                    ->searchable(),
                ImageColumn::make('badge_image'),
                ImageColumn::make('cone_image'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
