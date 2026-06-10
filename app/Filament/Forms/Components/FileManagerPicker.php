<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class FileManagerPicker extends Field
{
    protected string $view = 'filament.forms.components.file-manager-picker';

    protected bool $isMultiple = false;

    protected function setUp(): void
    {
        parent::setUp();

        // Expose the flag to the Blade view.
        $this->viewData(['multiple' => false]);
    }

    public function multiple(bool $condition = true): static
    {
        $this->isMultiple = $condition;
        $this->viewData(['multiple' => $condition]);

        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }
}
