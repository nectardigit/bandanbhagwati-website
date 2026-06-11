<?php

namespace App\Filament\Resources\HomeContents;

use App\Filament\Resources\HomeContents\Pages\CreateHomeContent;
use App\Filament\Resources\HomeContents\Pages\EditHomeContent;
use App\Filament\Resources\HomeContents\Pages\ListHomeContents;
use App\Filament\Resources\HomeContents\Schemas\HomeContentForm;
use App\Filament\Resources\HomeContents\Tables\HomeContentsTable;
use App\Models\HomeContent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HomeContentResource extends Resource
{
    protected static ?string $model = HomeContent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Home Page';

    protected static ?string $modelLabel = 'Home Page';

    protected static ?int $navigationSort = 0;

    public static function canCreate(): bool
    {
        return false;
    }

    /** Single-record resource: clicking the sidebar item opens the editor directly. */
    public static function getNavigationUrl(): string
    {
        return static::getUrl('edit', ['record' => HomeContent::singleton()->getKey()]);
    }

    public static function form(Schema $schema): Schema
    {
        return HomeContentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HomeContentsTable::configure($table);
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
            'index' => ListHomeContents::route('/'),
            'create' => CreateHomeContent::route('/create'),
            'edit' => EditHomeContent::route('/{record}/edit'),
        ];
    }
}
