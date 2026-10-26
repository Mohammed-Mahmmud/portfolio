<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Project')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('category')
                            ->placeholder('ERP · Fintech'),
                        TextInput::make('url')
                            ->label('Live URL')
                            ->url(),
                        Textarea::make('summary')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        TagsInput::make('tech_stack')
                            ->placeholder('Add technology')
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
                        FileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->directory('projects'),
                        Toggle::make('is_featured')
                            ->label('Featured'),
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
