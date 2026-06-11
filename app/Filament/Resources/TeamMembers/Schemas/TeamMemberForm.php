<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use App\Filament\Forms\Components\FileManagerPicker;
use App\Models\TeamMember;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                Select::make('role')
                    ->options(fn () => TeamMember::query()->whereNotNull('role')->where('role', '!=', '')->distinct()->orderBy('role')->pluck('role', 'role')->all())
                    ->searchable()
                    ->native(false)
                    ->createOptionForm([TextInput::make('role')->label('New role')->required()])
                    ->createOptionUsing(fn (array $data) => $data['role'])
                    ->helperText('Pick a role or add a new one.'),

                Select::make('department')
                    ->options(fn () => TeamMember::query()->whereNotNull('department')->where('department', '!=', '')->distinct()->orderBy('department')->pluck('department', 'department')->all())
                    ->searchable()
                    ->native(false)
                    ->createOptionForm([TextInput::make('department')->label('New department')->required()])
                    ->createOptionUsing(fn (array $data) => $data['department'])
                    ->helperText('Members are grouped under this heading on the Team page. Pick one or add a new one.'),
                FileManagerPicker::make('photo')
                    ->label('Photo'),
                TextInput::make('facebook'),
                TextInput::make('instagram'),
                TextInput::make('twitter'),
                TextInput::make('linkedin'),
                TextInput::make('youtube'),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
