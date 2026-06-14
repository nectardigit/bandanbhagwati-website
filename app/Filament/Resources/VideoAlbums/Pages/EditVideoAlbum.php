<?php

namespace App\Filament\Resources\VideoAlbums\Pages;

use App\Filament\Resources\VideoAlbums\VideoAlbumResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVideoAlbum extends EditRecord
{
    protected static string $resource = VideoAlbumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
