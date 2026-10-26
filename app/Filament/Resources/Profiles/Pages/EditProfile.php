<?php

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\ProfileResource;
use App\Models\Profile;
use Filament\Resources\Pages\EditRecord;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    protected static ?string $title = 'My Profile';

    public function mount(int|string|null $record = null): void
    {
        $profile = Profile::query()->firstOrCreate([], ['name' => 'Your Name', 'title' => 'Your Title']);

        parent::mount($profile->getKey());
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
