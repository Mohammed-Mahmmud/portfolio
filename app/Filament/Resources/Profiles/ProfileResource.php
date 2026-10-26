<?php

namespace App\Filament\Resources\Profiles;

use App\Filament\Resources\Profiles\Pages\EditProfile;
use App\Filament\Resources\Profiles\Schemas\ProfileForm;
use App\Models\Profile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'My Profile';

    protected static ?int $navigationSort = 0;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ProfileForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditProfile::route('/'),
        ];
    }
}
