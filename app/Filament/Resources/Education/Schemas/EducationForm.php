<?php

namespace App\Filament\Resources\Education\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('type')
                            ->options([
                                'degree' => 'Degree',
                                'certification' => 'Certification',
                                'course' => 'Course',
                            ])
                            ->default('degree')
                            ->required(),
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('institution')
                            ->required(),
                        TextInput::make('period')
                            ->placeholder('2015 — 2019'),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }
}
