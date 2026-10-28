<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Messages\MessageResource;
use App\Models\Message;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestMessages extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Latest messages';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Message::query()->latest()->limit(5))
            ->paginated(false)
            ->emptyStateHeading('No messages yet')
            ->emptyStateIcon(Heroicon::OutlinedInbox)
            ->columns([
                IconColumn::make('read_at')
                    ->label('')
                    ->state(fn (Message $record) => $record->read_at === null)
                    ->icon(fn (bool $state) => $state ? Heroicon::Envelope : Heroicon::EnvelopeOpen)
                    ->color(fn (bool $state) => $state ? 'primary' : 'gray')
                    ->tooltip(fn (bool $state) => $state ? 'Unread' : 'Read'),
                TextColumn::make('name')
                    ->weight('bold')
                    ->description(fn (Message $record) => $record->email),
                TextColumn::make('subject')
                    ->placeholder('No subject')
                    ->limit(40),
                TextColumn::make('body')
                    ->label('Message')
                    ->limit(60)
                    ->color('gray'),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->since(),
            ])
            ->headerActions([
                Action::make('all')
                    ->label('Open inbox')
                    ->icon(Heroicon::OutlinedArrowRight)
                    ->link()
                    ->url(MessageResource::getUrl()),
            ]);
    }
}
