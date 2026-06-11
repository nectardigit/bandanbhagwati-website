<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                FileManagerPicker::make('logo')->label('Logo'),
                TextInput::make('url')->label('Website (optional)')->url(),
                TextInput::make('sort')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]);
    }
}
