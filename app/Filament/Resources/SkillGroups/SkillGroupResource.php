<?php

namespace App\Filament\Resources\SkillGroups;

use App\Filament\Resources\SkillGroups\Pages\ListSkillGroups;
use App\Filament\Resources\SkillGroups\Schemas\SkillGroupForm;
use App\Filament\Resources\SkillGroups\Tables\SkillGroupsTable;
use App\Models\SkillGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SkillGroupResource extends Resource
{
    protected static ?string $model = SkillGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SkillGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SkillGroupsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSkillGroups::route('/'),
        ];
    }
}
