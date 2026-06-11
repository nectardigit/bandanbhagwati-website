<?php

namespace App\Filament\Resources\HomeContents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomeContentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hero_title')
                    ->searchable(),
                TextColumn::make('equip_title')
                    ->searchable(),
                TextColumn::make('cat_eyebrow')
                    ->searchable(),
                TextColumn::make('cat_title')
                    ->searchable(),
                TextColumn::make('services_title')
                    ->searchable(),
                TextColumn::make('projects_eyebrow')
                    ->searchable(),
                TextColumn::make('projects_title')
                    ->searchable(),
                TextColumn::make('ongoing_eyebrow')
                    ->searchable(),
                TextColumn::make('ongoing_title')
                    ->searchable(),
                TextColumn::make('cta_eyebrow')
                    ->searchable(),
                TextColumn::make('cta_title')
                    ->searchable(),
                TextColumn::make('faq_eyebrow')
                    ->searchable(),
                TextColumn::make('faq_title')
                    ->searchable(),
                TextColumn::make('testi_eyebrow')
                    ->searchable(),
                TextColumn::make('testi_title')
                    ->searchable(),
                TextColumn::make('blog_eyebrow')
                    ->searchable(),
                TextColumn::make('blog_title')
                    ->searchable(),
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
