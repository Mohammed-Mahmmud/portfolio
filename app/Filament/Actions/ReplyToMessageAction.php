<?php

namespace App\Filament\Actions;

use App\Mail\ContactReply;
use App\Models\Message;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Throwable;

/**
 * Replies to a contact-form message by email from inside the admin, in a modal.
 */
class ReplyToMessageAction
{
    public static function make(): Action
    {
        return Action::make('reply')
            ->icon(Heroicon::OutlinedPaperAirplane)
            ->color('primary')
            ->modalHeading(fn (Message $record) => 'Reply to '.$record->name)
            ->modalDescription(fn (Message $record) => $record->email)
            ->modalIcon(Heroicon::OutlinedPaperAirplane)
            ->modalWidth(Width::ThreeExtraLarge)
            ->modalSubmitActionLabel('Send reply')
            ->fillForm(fn (Message $record) => [
                'subject' => Str::startsWith((string) $record->subject, 'Re:')
                    ? $record->subject
                    : 'Re: '.($record->subject ?: 'Your message'),
                'body' => 'Hi '.Str::of($record->name)->explode(' ')->first().",\n\nThank you for reaching out.\n\n\n\nBest regards,",
            ])
            ->schema([
                TextInput::make('subject')
                    ->required()
                    ->maxLength(190),
                Textarea::make('body')
                    ->label('Message')
                    ->required()
                    ->rows(10)
                    ->maxLength(10000)
                    ->helperText('Your signature (name, title, phone, LinkedIn, website) and their original message are added automatically.'),
                Section::make('Their message')
                    ->collapsible()
                    ->compact()
                    ->schema([
                        TextEntry::make('original')
                            ->hiddenLabel()
                            ->state(fn (Message $record) => new HtmlString(nl2br(e($record->body))))
                            ->prose(),
                    ]),
            ])
            ->action(function (Message $record, array $data, Action $action): void {
                try {
                    Mail::to($record->email, $record->name)->send(new ContactReply($record, $data['subject'], $data['body']));
                } catch (Throwable $exception) {
                    report($exception);

                    Notification::make()
                        ->title('Reply not sent')
                        ->body('The email server rejected the message: '.Str::limit($exception->getMessage(), 160))
                        ->danger()
                        ->persistent()
                        ->send();

                    $action->halt();
                }

                $record->forceFill([
                    'read_at' => $record->read_at ?? now(),
                    'replied_at' => now(),
                ])->save();

                Notification::make()
                    ->title('Reply sent')
                    ->body('Sent to '.$record->email)
                    ->success()
                    ->send();
            });
    }
}
