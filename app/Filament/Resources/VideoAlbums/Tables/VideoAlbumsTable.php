<?php

namespace App\Filament\Resources\VideoAlbums\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VideoAlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->columns([
                ImageColumn::make('cover')
                    ->getStateUsing(fn ($record) => $record->cover ? url($record->cover) : null)
                    ->height(46),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('videos')
                    ->label('Videos')
                    ->getStateUsing(fn ($record) => is_array($record->videos) ? count($record->videos) : 0),
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
