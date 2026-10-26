@props(['profile', 'title' => null, 'description' => null, 'home' => false])

@php
    $pageTitle = $title ? $title.' · '.$profile->name : $profile->name.' — '.$profile->title;
    $metaDescription = \Illuminate\Support\Str::limit($description ?? $profile->summary, 160);
    $sectionLink = fn (string $id) => $home ? '#'.$id : route('home').'#'.$id;
    $nav = ['about' => 'About', 'experience' => 'Experience', 'projects' => 'Projects', 'skills' => 'Skills', 'contact' => 'Contact'];
    $initials = \Illuminate\Support\Str::of($profile->name)->explode(' ')->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:type" content="website">
    @if ($profile->avatar)
        <meta property="og:image" content="{{ asset('storage/'.$profile->avatar) }}">
    @endif
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='22' fill='%234f46e5'/><text x='50' y='67' font-size='48' font-weight='700' text-anchor='middle' fill='white' font-family='Arial'>{{ $initials }}</text></svg>">
    <script>
        try {
            const stored = localStorage.getItem('theme');
            if (stored === 'dark' || (!stored && matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        } catch {}
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <a href="#content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-lg focus:bg-indigo-600 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white">Skip to content</a>

    <header data-header class="group sticky top-0 z-40 border-b border-transparent bg-zinc-50/80 backdrop-blur-lg transition-colors [&.is-scrolled]:border-zinc-200 dark:bg-zinc-950/80 dark:[&.is-scrolled]:border-zinc-800">
        <nav class="container-page flex h-16 items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if ($profile->avatar)
                    <img src="{{ asset('storage/'.$profile->avatar) }}" alt="" class="size-9 rounded-full object-cover ring-2 ring-white dark:ring-zinc-800">
                @else
                    <span class="grid size-9 place-items-center rounded-full bg-indigo-600 text-sm font-bold text-white">{{ $initials }}</span>
                @endif
                <span class="hidden leading-tight sm:block">
                    <span class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $profile->name }}</span>
                    <span class="block text-xs text-zinc-500">{{ $profile->title }}</span>
                </span>
            </a>

            <ul class="hidden items-center gap-1 rounded-full border border-zinc-200 bg-white/70 px-2 py-1 text-sm font-medium shadow-sm md:flex dark:border-zinc-800 dark:bg-zinc-900/70">
                @foreach ($nav as $id => $label)
                    <li>
                        <a href="{{ $sectionLink($id) }}" data-nav-link
                           class="block rounded-full px-3.5 py-1.5 text-zinc-700 transition hover:text-indigo-600 data-[active]:bg-indigo-50 data-[active]:text-indigo-700 dark:text-zinc-300 dark:hover:text-indigo-400 dark:data-[active]:bg-indigo-500/10 dark:data-[active]:text-indigo-300">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-2">
                <button type="button" data-theme-toggle aria-label="Toggle dark mode"
                        class="grid size-9 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-600 shadow-sm transition hover:text-indigo-600 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:text-indigo-400">
                    <x-ui.icon name="moon" class="size-4 dark:hidden" />
                    <x-ui.icon name="sun" class="hidden size-4 dark:block" />
                </button>
                @if ($profile->cv_file)
                    <a href="{{ asset('storage/'.$profile->cv_file) }}" target="_blank" rel="noopener" class="btn-primary hidden !py-2 sm:inline-flex">
                        <x-ui.icon name="download" class="size-4" /> Resume
                    </a>
                @endif
                <button type="button" data-menu-button aria-expanded="false" aria-controls="mobile-menu" aria-label="Open menu"
                        class="grid size-9 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-700 shadow-sm md:hidden dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-200">
                    <x-ui.icon name="menu" class="size-4" />
                </button>
            </div>
        </nav>

        <div id="mobile-menu" data-menu class="hidden border-t border-zinc-200 bg-white md:hidden dark:border-zinc-800 dark:bg-zinc-900">
            <ul class="container-page divide-y divide-zinc-100 py-2 text-base font-medium dark:divide-zinc-800">
                @foreach ($nav as $id => $label)
                    <li><a href="{{ $sectionLink($id) }}" class="block py-3 text-zinc-800 dark:text-zinc-200">{{ $label }}</a></li>
                @endforeach
                @if ($profile->cv_file)
                    <li><a href="{{ asset('storage/'.$profile->cv_file) }}" target="_blank" rel="noopener" class="block py-3 text-indigo-600 dark:text-indigo-400">Download Resume</a></li>
                @endif
            </ul>
        </div>
    </header>

    <main id="content">
        {{ $slot }}
    </main>

    <footer class="mt-24 border-t border-zinc-200 dark:border-zinc-800">
        <div class="container-page flex flex-col items-center justify-between gap-6 py-10 sm:flex-row">
            <ul class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                @foreach ($nav as $id => $label)
                    <li><a href="{{ $sectionLink($id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">{{ $label }}</a></li>
                @endforeach
            </ul>
            <div class="flex items-center gap-4">
                @if ($profile->linkedin_url)<a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn" class="text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400"><x-ui.icon name="linkedin" /></a>@endif
                @if ($profile->github_url)<a href="{{ $profile->github_url }}" target="_blank" rel="noopener" aria-label="GitHub" class="text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400"><x-ui.icon name="github" /></a>@endif
                @if ($profile->email)<a href="mailto:{{ $profile->email }}" aria-label="Email" class="text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400"><x-ui.icon name="mail" /></a>@endif
            </div>
            <p class="text-sm text-zinc-500">&copy; {{ date('Y') }} {{ $profile->name }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
