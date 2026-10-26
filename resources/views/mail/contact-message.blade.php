<x-mail::message>
# New message from your portfolio

**From:** {{ $contactMessage->name }} &lt;{{ $contactMessage->email }}&gt;<br>
**Subject:** {{ $contactMessage->subject ?: '—' }}<br>
**Received:** {{ $contactMessage->created_at->format('d M Y, H:i') }}

<x-mail::panel>
{{ $contactMessage->body }}
</x-mail::panel>

Just hit **Reply** to answer {{ $contactMessage->name }} directly.

<x-mail::button :url="route('filament.admin.resources.messages.index')">
Open inbox
</x-mail::button>
</x-mail::message>
