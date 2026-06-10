<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SiteSettingForm
{
    /** Setting keys whose value is a media file (use the File Manager picker). */
    private static function isMedia($record): bool
    {
        return $record && Str::contains($record->key, ['image', 'video', 'photo', 'logo', 'icon']);
    }

    public static function configure(Schema $schema): Schema
    {
        $isMedia = fn ($record) => self::isMedia($record);
        $isText  = fn ($record) => ! self::isMedia($record);

        return $schema
            ->components([
                TextInput::make('key')
                    ->required()
                    ->disabledOn('edit')
                    ->helperText('e.g. phone, email, address, social_facebook, stat_awards, hero_title, hero_video'),

                // Media keys (…image / …video / …photo / …logo / …icon) → File Manager picker.
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
