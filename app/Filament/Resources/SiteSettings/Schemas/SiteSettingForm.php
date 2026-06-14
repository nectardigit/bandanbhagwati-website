<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SiteSettingForm
{
    /** Plural media keys (e.g. hero_videos, hero_images) → pick MANY files. */
    private static function isMulti($record): bool
    {
        return $record && Str::contains($record->key, ['videos', 'images', 'galleries']);
    }

    /** Setting keys whose value is a single media file (use the File Manager picker). */
    private static function isMedia($record): bool
    {
        return $record && ! self::isMulti($record) && Str::contains($record->key, ['image', 'video', 'photo', 'logo', 'icon']);
    }

    public static function configure(Schema $schema): Schema
    {
        $isMulti = fn ($record) => self::isMulti($record);
        $isMedia = fn ($record) => self::isMedia($record);
        $isText  = fn ($record) => ! self::isMedia($record) && ! self::isMulti($record);

        return $schema
            ->components([
                TextInput::make('key')
                    ->required()
                    ->disabledOn('edit')
                    ->helperText('e.g. phone, email, address, hero_title, hero_video, hero_videos (multiple)'),

                // Plural media keys (hero_videos / hero_images) → pick multiple files (stored as JSON).
                FileManagerPicker::make('value')
                    ->label('Files — pick multiple (rotates on the site)')
                    ->multiple()
                    ->visible($isMulti)
                    ->dehydrated($isMulti)
                    ->formatStateUsing(fn ($state) => is_array($state) ? $state : (json_decode((string) $state, true) ?: []))
                    ->dehydrateStateUsing(fn ($state) => json_encode(array_values(array_filter((array) $state))))
                    ->columnSpanFull(),

                // Single media keys (…image / …video / …photo / …logo / …icon) → File Manager picker.
                FileManagerPicker::make('value')
                    ->label('File (pick from File Manager)')
                    ->visible($isMedia)
                    ->dehydrated($isMedia)
                    ->columnSpanFull(),

                // Everything else → plain text.
                Textarea::make('value')
                    ->rows(3)
                    ->visible($isText)
                    ->dehydrated($isText)
                    ->columnSpanFull(),
            ]);
    }
}
