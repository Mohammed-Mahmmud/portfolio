<?php

namespace App\Filament\Resources\SkillGroups\Schemas;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SkillGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        TagsInput::make('items')
                            ->label('Skills')
                            ->reorderable()
                            ->columnSpanFull(),
                        Toggle::make('is_visible')
                            ->label('Visible')
                            ->default(true),
                    ]),
            ]);
    }
}
