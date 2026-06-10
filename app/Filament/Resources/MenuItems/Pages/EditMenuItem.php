<?php

namespace App\Filament\Resources\MenuItems\Pages;

use App\Filament\Resources\MenuItems\MenuItemResource;
use App\Models\Page;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMenuItem extends EditRecord
{
    protected static string $resource = MenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    // Load the linked page's content into the editor.
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (($data['type'] ?? null) === 'page' && $this->record->page) {
            $data['page_content'] = $this->record->page->body;
        }

        return $data;
    }

    // Save the content back to the page (create one if needed).
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['type'] ?? 'link') === 'page') {
            $page = $this->record->page;

            if ($page) {
                $page->update([
                    'title' => $data['label'],
                    'body'  => $data['page_content'] ?? $page->body,
                ]);
            } else {
                $page = Page::create([
                    'title'        => $data['label'],
                    'slug'         => CreateMenuItem::uniqueSlug($data['label']),
                    'body'         => $data['page_content'] ?? '',
                    'is_published' => true,
                ]);
            }

            $data['page_id'] = $page->getKey();
        }

        unset($data['page_content']);

        return $data;
    }
}
