<?php

namespace App\Filament\Resources\HomeContents\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomeContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero')
                    ->description('Leave blank to keep the styled default headline ("We Are Your Trusted Construction Partner").')
                    ->schema([
                        TextInput::make('hero_title')->label('Headline override'),
                    ])->collapsible(),

                Section::make('Equipment Showcase')->schema([
                    TextInput::make('equip_title')->label('Title'),
                    Textarea::make('equip_sub')->label('Description')->rows(2),
                ])->collapsible(),

                Section::make('Equipment Categories')->schema([
                    TextInput::make('cat_eyebrow')->label('Eyebrow'),
                    TextInput::make('cat_title')->label('Title'),
                    Textarea::make('cat_sub')->label('Description')->rows(2),
                ])->collapsible(),

                Section::make('Trusted Construction Services')->schema([
                    TextInput::make('services_title')->label('Title'),
                    Textarea::make('services_sub')->label('Description')->rows(2),
                ])->collapsible(),

                Section::make('Showcasing Our Work (projects)')->schema([
                    TextInput::make('projects_eyebrow')->label('Eyebrow'),
                    TextInput::make('projects_title')->label('Title'),
                    Textarea::make('projects_sub')->label('Description')->rows(2),
                ])->collapsible(),

                Section::make('Work in Action (ongoing)')->schema([
                    TextInput::make('ongoing_eyebrow')->label('Eyebrow'),
                    TextInput::make('ongoing_title')->label('Title'),
                    Textarea::make('ongoing_sub')->label('Description')->rows(2),
                ])->collapsible(),

                Section::make('Contact CTA ("Have a Project in Mind?")')->schema([
                    TextInput::make('cta_eyebrow')->label('Eyebrow'),
                    TextInput::make('cta_title')->label('Title'),
                    Textarea::make('cta_text')->label('Text')->rows(3),
                ])->collapsible(),

                Section::make('FAQ')->schema([
                    TextInput::make('faq_eyebrow')->label('Eyebrow'),
                    TextInput::make('faq_title')->label('Title'),
                    Textarea::make('faq_sub')->label('Description')->rows(2),
                ])->collapsible(),

                Section::make('Testimonials')->schema([
                    TextInput::make('testi_eyebrow')->label('Eyebrow'),
                    TextInput::make('testi_title')->label('Title'),
                    Textarea::make('testi_text')->label('Text')->rows(3),
                ])->collapsible(),

                Section::make('Page Headers — Services / Equipment / Projects / Team')
                    ->description('Title and description shown at the top of each listing page. Leave blank to keep the current text.')
                    ->schema([
                        TextInput::make('service_page_title')->label('Services — title')->placeholder('Solutions We Provide'),
                        Textarea::make('service_page_desc')->label('Services — description')->rows(2),
                        TextInput::make('equipment_page_title')->label('Equipment — title')->placeholder('Equipment for Rent'),
                        Textarea::make('equipment_page_desc')->label('Equipment — description')->rows(2),
                        TextInput::make('project_page_title')->label('Projects — title')->placeholder('Showcasing Our Work'),
                        Textarea::make('project_page_desc')->label('Projects — description')->rows(2),
                        TextInput::make('team_page_title')->label('Team — title')->placeholder('Meet the Team'),
                        Textarea::make('team_page_desc')->label('Team — description')->rows(2),
                    ])->collapsible(),

                Section::make('Our Clients')->schema([
                    TextInput::make('clients_eyebrow')->label('Eyebrow'),
                    TextInput::make('clients_title')->label('Title'),
                    Textarea::make('clients_sub')->label('Description (shown on the Clients page)')->rows(2),
                ])->collapsible(),

                Section::make('Insights & Updates (blog)')->schema([
                    TextInput::make('blog_eyebrow')->label('Eyebrow'),
                    TextInput::make('blog_title')->label('Title'),
                    Textarea::make('blog_sub')->label('Description')->rows(2),
                ])->collapsible(),
            ]);
    }
}
