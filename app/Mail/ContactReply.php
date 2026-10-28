<?php

namespace App\Mail;

use App\Models\Message;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * A personal reply to a contact-form message. Recipients are often recruiters and
 * companies, so it reads like a normal email from a person rather than a system notice.
 */
class ContactReply extends Mailable
{
    use Queueable, SerializesModels;

    public Profile $profile;

    public function __construct(
        public Message $original,
        public string $replySubject,
        public string $replyBody,
    ) {
        $this->profile = Profile::current();
    }

    public function envelope(): Envelope
    {
        $replyTo = $this->profile->email ? [new Address($this->profile->email, $this->profile->name)] : [];

        return new Envelope(
            from: new Address(config('mail.from.address'), $this->profile->name),
            replyTo: $replyTo,
            subject: $this->replySubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-reply',
            text: 'mail.contact-reply-text',
        );
    }
}
