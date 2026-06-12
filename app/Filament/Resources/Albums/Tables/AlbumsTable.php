<?php

namespace App\Filament\Resources\Albums\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->columns([
                ImageColumn::make('cover')
                    ->getStateUsing(fn ($record) => $record->cover ? url($record->cover) : (! empty($record->images[0]) ? url($record->images[0]) : null))
                    ->height(46),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('images')
                    ->label('Photos')
                    ->getStateUsing(fn ($record) => is_array($record->images) ? count($record->images) : 0),
                TextColumn::make('sort')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
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
