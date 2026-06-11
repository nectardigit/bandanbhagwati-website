<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    // only write the password when a value is entered (so editing without
                    // retyping keeps the old one). The model's "hashed" cast hashes it.
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->helperText('Leave blank when editing to keep the current password.'),

                Toggle::make('is_admin')
                    ->label('Admin access')
                    ->default(true)
                    ->helperText('Only users with this on can sign in to this admin panel.'),
            ]);
    }
}
