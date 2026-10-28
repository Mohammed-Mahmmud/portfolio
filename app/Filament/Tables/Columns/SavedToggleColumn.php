<?php

namespace App\Filament\Tables\Columns;

use Filament\Notifications\Notification;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Model;

/**
 * A toggle column that confirms the change with a "Saved" notification,
 * the same feedback the edit modal gives.
 */
class SavedToggleColumn extends ToggleColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function (Model $record, bool $state): void {
            $title = $record->getAttribute('title') ?? $record->getAttribute('name') ?? $record->getAttribute('role');

            Notification::make()
                ->title('Saved')
                ->body(trim($this->getLabel().' '.($state ? 'turned on' : 'turned off').($title ? ' for '.$title : '')))
                ->success()
                ->send();
        });
    }
}
