<?php

namespace App\Filament\Resources\Faqs\Schemas;

use App\Models\Faq;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->required(),
                Select::make('category')
                    ->options(fn () => Faq::query()->whereNotNull('category')->where('category', '!=', '')->distinct()->orderBy('category')->pluck('category', 'category')->all())
                    ->searchable()
                    ->native(false)
                    ->createOptionForm([TextInput::make('category')->label('New category')->required()])
                    ->createOptionUsing(fn (array $data) => $data['category'])
                    ->helperText('Questions are grouped under this heading on the FAQ page. Pick one or add a new one.'),
                Textarea::make('answer')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
