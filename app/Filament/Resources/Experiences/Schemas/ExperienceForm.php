<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Position')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextInput::make('role')
                            ->required(),
                        TextInput::make('company')
                            ->required(),
                        TextInput::make('location'),
                        Toggle::make('is_remote')
                            ->label('Remote')
                            ->inline(false),
                        DatePicker::make('start_date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->helperText('Leave empty for current position'),
                        TagsInput::make('tech_stack')
                            ->columnSpanFull(),
                        Repeater::make('highlights')
                            ->simple(TextInput::make('value')->required())
                            ->reorderable()
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),
                Section::make('Display')
                    ->columnSpan(1)
                    ->schema([
                        Toggle::make('is_visible')
                            ->label('Visible')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }
}
