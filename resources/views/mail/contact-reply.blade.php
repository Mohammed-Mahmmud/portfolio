<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $replySubject }}</title>
</head>
<body style="margin:0;padding:0;background:#ffffff;">
    <div style="max-width:620px;padding:24px 20px;font-family:-apple-system,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;font-size:15px;line-height:1.6;color:#1f2937;">
        <div>{!! nl2br(e($replyBody)) !!}</div>

        <table role="presentation" cellpadding="0" cellspacing="0" style="margin-top:28px;border-top:1px solid #e5e7eb;padding-top:16px;">
            <tr>
                <td style="font-size:14px;line-height:1.5;color:#374151;">
                    <strong style="font-size:15px;color:#111827;">{{ $profile->name }}</strong><br>
                    <span style="color:#6b7280;">{{ $profile->title }}</span><br>
                    @if ($profile->phone)
                        {{ $profile->phone }}<br>
                    @endif
                    @if ($profile->linkedin_url)
                        <a href="{{ $profile->linkedin_url }}" style="color:#4f46e5;text-decoration:none;">LinkedIn</a>
                        &nbsp;·&nbsp;
                    @endif
                    <a href="{{ config('app.url') }}" style="color:#4f46e5;text-decoration:none;">{{ preg_replace('#^https?://#', '', rtrim(config('app.url'), '/')) }}</a>
                </td>
            </tr>
        </table>

        <div style="margin-top:28px;font-size:13px;color:#6b7280;">
            On {{ $original->created_at->format('D, M j, Y \a\t g:i A') }}, {{ $original->name }} &lt;{{ $original->email }}&gt; wrote:
        </div>
        <blockquote style="margin:8px 0 0;padding:0 0 0 12px;border-left:3px solid #e5e7eb;font-size:13px;color:#6b7280;">
            @if ($original->subject)
                <strong>{{ $original->subject }}</strong><br>
            @endif
            {!! nl2br(e($original->body)) !!}
        </blockquote>
    </div>
</body>
</html>
