<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Filament\Tables\Columns\SavedToggleColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->imageWidth(96)
                    ->imageHeight(54)
                    ->extraImgAttributes(['class' => 'rounded-md object-cover']),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->category),
                TextColumn::make('url')
                    ->label('Live URL')
                    ->formatStateUsing(fn (string $state) => preg_replace('#^https?://(www\.)?#', '', rtrim($state, '/')))
                    ->url(fn ($record) => $record->url, shouldOpenInNewTab: true)
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->iconPosition('after')
                    ->color('primary')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('tech_stack')
                    ->badge()
                    ->limitList(3),
                SavedToggleColumn::make('is_featured')
                    ->label('Featured'),
                SavedToggleColumn::make('is_visible')
                    ->label('Visible'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_featured')->label('Featured'),
                TernaryFilter::make('is_visible')->label('Visible'),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth(Width::FiveExtraLarge),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
