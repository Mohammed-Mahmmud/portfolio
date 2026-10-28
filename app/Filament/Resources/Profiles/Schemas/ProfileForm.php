<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // Two independent columns, so a tall section on one side doesn't leave gaps on the other.
                Group::make([
                    self::heroSection(),
                    self::contactSection(),
                    self::expertiseSection(),
                ])->columnSpan(2),
                Group::make([
                    self::statsSection(),
                    self::mediaSection(),
                ])->columnSpan(1),
            ]);
    }

    protected static function heroSection(): Section
    {
        return Section::make('Hero')
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('tagline')
                    ->columnSpanFull(),
                Textarea::make('summary')
                    ->rows(4)
                    ->columnSpanFull(),
                Textarea::make('about')
                    ->helperText('Separate paragraphs with a blank line.')
                    ->rows(10)
                    ->columnSpanFull(),
            ]);
    }

    protected static function contactSection(): Section
    {
        return Section::make('Contact')
            ->columns(2)
            ->schema([
                TextInput::make('email')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('location'),
                TextInput::make('linkedin_url')
                    ->label('LinkedIn URL')
                    ->url(),
                TextInput::make('github_url')
                    ->label('GitHub URL')
                    ->url(),
            ]);
    }

    protected static function expertiseSection(): Section
    {
        return Section::make('What I Do')
            ->description('Expertise cards shown under the About section.')
            ->schema([
                Repeater::make('expertise')
                    ->hiddenLabel()
                    ->schema([
                        Select::make('icon')
                            ->options([
                                'credit-card' => 'Credit card',
                                'layers' => 'Layers',
                                'gauge' => 'Gauge',
                                'shield-check' => 'Shield',
                                'server' => 'Server',
                                'code' => 'Code',
                                'users' => 'Users',
                                'zap' => 'Lightning',
                            ])
                            ->default('code')
                            ->required(),
                        TextInput::make('title')
                            ->required()
                            ->columnSpan(2),
                        Textarea::make('description')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->itemLabel(fn (array $state) => $state['title'] ?? null)
                    ->collapsible()
                    ->reorderable()
                    ->maxItems(6),
            ]);
    }

    protected static function statsSection(): Section
    {
        return Section::make('Stats')
            ->schema([
                TextInput::make('years_experience')
                    ->label('Years of experience')
                    ->helperText('Shown across the site — no need to add it as a stat below.')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(60)
                    ->suffix('years')
                    ->required(),
                Checkbox::make('years_experience_plus')
                    ->label('Show "+" after the number (e.g. 6+ years)')
                    ->default(true),
                Repeater::make('stats')
                    ->label('Other stats')
                    ->schema([
                        TextInput::make('value')
                            ->placeholder('25M+')
                            ->required(),
                        TextInput::make('label')
                            ->placeholder('Neo4j records optimized')
                            ->required()
                            ->columnSpan(2),
                    ])
                    ->columns(3)
                    ->reorderable()
                    ->defaultItems(0)
                    ->addActionLabel('Add stat'),
            ]);
    }

    protected static function mediaSection(): Section
    {
        return Section::make('Media')
            ->schema([
                FileUpload::make('avatar')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->imageEditorAspectRatioOptions(['1:1', '4:5'])
                    ->imageEditorViewportWidth(800)
                    ->imageEditorViewportHeight(800)
                    ->disk('public')
                    ->directory('profile')
                    ->extraAttributes([
                        'style' => 'z-index: 9999 !important; position: relative;',
                    ]),
                FileUpload::make('cv_file')
                    ->label('CV (PDF)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('cv')
                    ->preserveFilenames(),
                Toggle::make('available_for_work'),
            ]);
    }
}
