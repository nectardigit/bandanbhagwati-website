<?php

namespace App\Filament\Resources\VideoAlbums;

use App\Filament\Resources\VideoAlbums\Pages\CreateVideoAlbum;
use App\Filament\Resources\VideoAlbums\Pages\EditVideoAlbum;
use App\Filament\Resources\VideoAlbums\Pages\ListVideoAlbums;
use App\Filament\Resources\VideoAlbums\Schemas\VideoAlbumForm;
use App\Filament\Resources\VideoAlbums\Tables\VideoAlbumsTable;
use App\Models\VideoAlbum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VideoAlbumResource extends Resource
{
    protected static ?string $model = VideoAlbum::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static ?string $navigationLabel = 'Video Albums';

    public static function form(Schema $schema): Schema
    {
        return VideoAlbumForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoAlbumsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideoAlbums::route('/'),
            'create' => CreateVideoAlbum::route('/create'),
            'edit' => EditVideoAlbum::route('/{record}/edit'),
        ];
    }
}
