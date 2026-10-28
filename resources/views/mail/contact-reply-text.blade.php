{!! $replyBody !!}

--
{!! $profile->name !!}
{!! $profile->title !!}
@if ($profile->phone)
{!! $profile->phone !!}
@endif
@if ($profile->linkedin_url)
{!! $profile->linkedin_url !!}
@endif
{!! rtrim(config('app.url'), '/') !!}

On {{ $original->created_at->format('D, M j, Y \a\t g:i A') }}, {!! $original->name !!} <{!! $original->email !!}> wrote:
@if ($original->subject)
> {!! $original->subject !!}
@endif
@foreach (preg_split('/\R/', $original->body) as $line)
> {!! $line !!}
@endforeach
