<?php

namespace App\Filament\Resources\Messages\Tables;

use App\Models\Message;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('read_at')
                    ->label('')
                    ->state(fn (Message $record) => $record->read_at === null)
                    ->icon(fn (bool $state) => $state ? Heroicon::Envelope : Heroicon::EnvelopeOpen)
                    ->color(fn (bool $state) => $state ? 'primary' : 'gray'),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Message $record) => $record->email),
                TextColumn::make('subject')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('read_at')
                    ->label('Read')
                    ->nullable(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->after(fn (Message $record) => $record->read_at ?? $record->forceFill(['read_at' => now()])->save()),
                Action::make('reply')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->url(fn (Message $record) => 'mailto:'.$record->email.'?subject='.rawurlencode('Re: '.($record->subject ?? 'Your message')))
                    ->openUrlInNewTab(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
