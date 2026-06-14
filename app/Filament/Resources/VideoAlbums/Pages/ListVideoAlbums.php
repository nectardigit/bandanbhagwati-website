<?php

namespace App\Filament\Resources\VideoAlbums\Pages;

use App\Filament\Resources\VideoAlbums\VideoAlbumResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVideoAlbums extends ListRecords
{
    protected static string $resource = VideoAlbumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
