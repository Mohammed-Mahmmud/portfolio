<x-layout :profile="$profile" :home="true">
    @php
        $current = $experiences->first(fn ($job) => $job->end_date === null);
        $categories = $featured->concat($others)
            ->flatMap(fn ($p) => array_map('trim', explode('·', (string) $p->category)))
            ->filter()->countBy()->sortDesc()->keys()->take(6);
        $categoryKey = fn ($p) => implode('|', array_map('trim', explode('·', (string) $p->category)));
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -top-40 -z-10 flex justify-center blur-3xl">
            <div class="aspect-[1155/678] w-[60rem] bg-gradient-to-tr from-indigo-300 to-sky-200 opacity-30 [clip-path:polygon(74%_44%,100%_61%,97%_26%,85%_0%,80%_2%,72%_32%,60%_62%,52%_68%,47%_58%,45%_34%,27%_76%,0%_64%,17%_100%,27%_76%,76%_97%,74%_44%)] dark:from-indigo-900 dark:to-sky-900"></div>
        </div>

        <div class="container-page grid items-center gap-14 pt-14 pb-20 lg:grid-cols-[1.25fr_1fr] lg:pt-24">
            <div>
                @if ($profile->available_for_work)
                    <p class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                        <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex size-2 rounded-full bg-emerald-500"></span></span>
                        Available for new opportunities
                    </p>
                @endif

                <p class="mt-6 text-lg font-medium text-zinc-500 dark:text-zinc-400">Hi, I'm {{ $profile->name }} 👋</p>
                <h1 class="mt-2 text-4xl leading-[1.1] font-extrabold text-zinc-900 sm:text-5xl lg:text-[3.4rem] dark:text-white">
                    {{ $profile->title }}
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed">{{ $profile->tagline }}</p>

                <div class="mt-9 flex flex-wrap items-center gap-3">
                    <a href="#contact" class="btn-primary"><x-ui.icon name="send" class="size-4" /> Get in touch</a>
                    <a href="#projects" class="btn-secondary">View projects <x-ui.icon name="arrow-right" class="size-4" /></a>
                </div>

                <div class="mt-9 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm">
                    @if ($profile->location)
                        <span class="inline-flex items-center gap-1.5"><x-ui.icon name="map-pin" class="size-4 text-zinc-400" />{{ $profile->location }}</span>
                    @endif
                    @if ($profile->linkedin_url)
                        <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400"><x-ui.icon name="linkedin" class="size-4" />LinkedIn</a>
                    @endif
                    @if ($profile->github_url)
                        <a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400"><x-ui.icon name="github" class="size-4" />GitHub</a>
                    @endif
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-sm lg:max-w-md">
                <div class="absolute inset-0 translate-x-4 translate-y-4 rotate-3 rounded-3xl bg-gradient-to-br from-indigo-500 to-sky-400 opacity-90"></div>
                <div class="relative overflow-hidden rounded-3xl border border-white/60 bg-zinc-100 shadow-2xl dark:border-zinc-800 dark:bg-zinc-900">
                    @if ($profile->avatar)
                        <img src="{{ asset('storage/'.$profile->avatar) }}" alt="Portrait of {{ $profile->name }}" class="aspect-[4/5] w-full object-cover">
                    @else
                        <div class="grid aspect-[4/5] w-full place-items-center text-7xl font-bold text-indigo-600">{{ mb_substr($profile->name, 0, 1) }}</div>
                    @endif
                </div>

                @if ($current)
                    <div class="absolute -bottom-6 -left-4 flex items-center gap-3 rounded-2xl border border-zinc-200 bg-white/95 px-4 py-3 shadow-xl backdrop-blur sm:-left-10 dark:border-zinc-700 dark:bg-zinc-900/95">
                        <span class="grid size-10 place-items-center rounded-xl bg-indigo-600 text-white"><x-ui.icon name="briefcase" class="size-5" /></span>
                        <span class="leading-tight">
                            <span class="block text-xs text-zinc-500">Currently at</span>
                            <span class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $current->company }}</span>
                        </span>
                    </div>
                @endif
                <div class="absolute -top-5 -right-3 rounded-2xl border border-zinc-200 bg-white/95 px-4 py-3 text-center shadow-xl backdrop-blur sm:-right-8 dark:border-zinc-700 dark:bg-zinc-900/95">
                    <span class="block text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $profile->yearsLabel() }}</span>
                    <span class="block text-xs text-zinc-500">Years of experience</span>
                </div>
            </div>
        </div>

        @if (! empty($profile->stats))
            <div class="container-page pb-8">
                {{-- Wraps to any number of stats; the -ml/-mt offset hides the outer edge of each cell's border. --}}
                <div class="card overflow-hidden">
                    <dl class="-mt-px -ml-px flex flex-wrap">
                        @foreach ($profile->stats as $stat)
                            <div class="flex min-w-[45%] flex-1 basis-48 sm:min-w-0 flex-col-reverse gap-1 border-t border-l border-zinc-200 px-6 py-6 text-center dark:border-zinc-800">
                                <dt class="text-sm text-zinc-500">{{ $stat['label'] }}</dt>
                                <dd class="font-display text-3xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        @endif
    </section>

    {{-- About --}}
    <section id="about" class="container-page reveal py-20">
        <div class="grid gap-12 lg:grid-cols-[1.4fr_1fr]">
            <div>
                <p class="eyebrow">About me</p>
                <h2 class="section-title">Engineering the systems businesses run on</h2>
                <div class="mt-6 space-y-4 text-base leading-relaxed">
                    @foreach (preg_split('/\R{2,}/', trim($profile->about ?? $profile->summary ?? '')) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>

            <aside class="card self-start p-6">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Quick facts</h3>
                <dl class="mt-4 divide-y divide-zinc-100 text-sm dark:divide-zinc-800">
                    @foreach (array_filter([
                        'Role' => $profile->title,
                        'Currently' => $current ? $current->role.' at '.$current->company : null,
                        'Experience' => $profile->years_experience ? $profile->yearsLabel().' years' : null,
                        'Location' => $profile->location,
                        'Email' => $profile->email,
                    ]) as $label => $value)
                        <div class="flex justify-between gap-4 py-3">
                            <dt class="text-zinc-500">{{ $label }}</dt>
                            <dd class="text-right font-medium text-zinc-900 dark:text-zinc-100">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
                @if ($profile->cv_file)
                    <a href="{{ asset('storage/'.$profile->cv_file) }}" download class="btn-secondary mt-5 w-full"><x-ui.icon name="download" class="size-4" /> Download full CV</a>
                @endif
            </aside>
        </div>

        @if (! empty($profile->expertise))
            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($profile->expertise as $item)
                    <div class="card group p-6 transition hover:-translate-y-1 hover:shadow-md">
                        <span class="grid size-11 place-items-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100 transition group-hover:bg-indigo-600 group-hover:text-white dark:bg-indigo-500/10 dark:text-indigo-400 dark:ring-indigo-500/20">
                            <x-ui.icon :name="$item['icon'] ?? 'code'" class="size-5" />
                        </span>
                        <h3 class="mt-5 text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed">{{ $item['description'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- Experience --}}
    <section id="experience" class="border-y border-zinc-200 bg-white py-20 dark:border-zinc-800 dark:bg-zinc-900/40">
        <div class="container-page reveal">
            <div class="max-w-2xl">
                <p class="eyebrow">Experience</p>
                <h2 class="section-title">Where I've worked</h2>
                <p class="mt-4">{{ $profile->yearsLabel() }} years building backend systems for ERP, fintech, tourism, real estate and e-learning products.</p>
            </div>

            <ol class="relative mt-12 space-y-6 before:absolute before:top-2 before:bottom-2 before:left-[19px] before:w-px before:bg-zinc-200 dark:before:bg-zinc-800">
                @foreach ($experiences as $job)
                    <li class="relative pl-14">
                        <span class="absolute top-6 left-0 grid size-10 place-items-center rounded-full border border-zinc-200 bg-white text-sm font-bold text-indigo-600 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:text-indigo-400">
                            {{ mb_strtoupper(mb_substr($job->company, 0, 1)) }}
                        </span>
                        <article class="card p-6 sm:p-7">
                            <header class="flex flex-wrap items-start justify-between gap-x-6 gap-y-2">
                                <div>
                                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $job->role }}</h3>
                                    <p class="mt-0.5 text-sm">
                                        <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ $job->company }}</span>
                                        @if ($job->location) · {{ $job->location }}@endif
                                        @if ($job->is_remote) · Remote @endif
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if (! $job->end_date)
                                        <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Current</span>
                                    @endif
                                    <span class="text-sm font-medium text-zinc-500">{{ $job->period() }}</span>
                                </div>
                            </header>
                            <ul class="mt-5 grid gap-2.5 text-sm leading-relaxed">
                                @foreach ($job->highlights ?? [] as $item)
                                    <li class="flex gap-3"><x-ui.icon name="check" class="mt-0.5 size-4 shrink-0 text-indigo-500" />{{ $item }}</li>
                                @endforeach
                            </ul>
                            @if (! empty($job->tech_stack))
                                <div class="mt-5 flex flex-wrap gap-1.5">
                                    @foreach ($job->tech_stack as $tech)
                                        <span class="chip">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </article>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Projects --}}
    <section id="projects" class="container-page py-20">
        <div class="reveal flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div class="max-w-2xl">
                <p class="eyebrow">Projects</p>
                <h2 class="section-title">Selected work</h2>
                <p class="mt-4">A selection of platforms I've designed, built or scaled — from multi-tenant ERPs to payment and auction systems.</p>
            </div>
            <a href="{{ route('archive') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">View all projects <x-ui.icon name="arrow-right" class="size-4" /></a>
        </div>

        <div data-filter-group class="reveal mt-8 flex flex-wrap gap-2">
            @foreach (collect(['all' => 'All'])->merge($categories->mapWithKeys(fn ($c) => [$c => $c])) as $value => $label)
                <button type="button" data-filter="{{ $value }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                        class="rounded-full border border-zinc-200 bg-white px-4 py-1.5 text-sm font-medium text-zinc-700 transition hover:border-indigo-300 aria-pressed:border-indigo-600 aria-pressed:bg-indigo-600 aria-pressed:text-white dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Featured --}}
        <div class="mt-10 grid gap-6 lg:grid-cols-3">
            @foreach ($featured as $project)
                <article data-category="{{ $categoryKey($project) }}" class="card reveal group flex flex-col overflow-hidden transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="relative h-44 overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-500 to-sky-500">
                        @if ($project->image)
                            <img src="{{ asset('storage/'.$project->image) }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="absolute inset-0 opacity-20 [background-image:radial-gradient(white_1px,transparent_1px)] [background-size:16px_16px]"></div>
                            <div class="relative flex h-full flex-col justify-end p-6">
                                <span class="text-xs font-semibold tracking-wider text-white/80 uppercase">{{ $project->category }}</span>
                                <span class="mt-1 font-display text-2xl font-bold text-white">{{ \Illuminate\Support\Str::before($project->title, ' —') }}</span>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 rounded-full bg-white/95 px-2.5 py-0.5 text-xs font-semibold text-indigo-700 shadow">Featured</span>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                            <a href="{{ route('projects.show', $project) }}" class="after:absolute after:inset-0">{{ $project->title }}</a>
                        </h3>
                        <p class="mt-2 flex-1 text-sm leading-relaxed">{{ $project->summary }}</p>
                        <div class="mt-5 flex flex-wrap gap-1.5">
                            @foreach (collect($project->tech_stack)->take(5) as $tech)
                                <span class="chip-accent">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 dark:text-indigo-400">Read case study <x-ui.icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" /></span>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Others --}}
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($others as $project)
                <article data-category="{{ $categoryKey($project) }}" class="card reveal group relative flex flex-col p-6 transition hover:border-indigo-300 hover:shadow-md dark:hover:border-indigo-500/40">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold tracking-wide text-indigo-600 uppercase dark:text-indigo-400">{{ $project->category }}</span>
                        <x-ui.icon name="arrow-right" class="size-4 -rotate-45 text-zinc-400 transition group-hover:text-indigo-600" />
                    </div>
                    <h3 class="mt-3 text-base font-semibold text-zinc-900 dark:text-zinc-100">
                        <a href="{{ route('projects.show', $project) }}" class="after:absolute after:inset-0">{{ $project->title }}</a>
                    </h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed">{{ $project->summary }}</p>
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        @foreach (collect($project->tech_stack)->take(4) as $tech)
                            <span class="chip">{{ $tech }}</span>
                        @endforeach
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Skills --}}
    <section id="skills" class="border-y border-zinc-200 bg-white py-20 dark:border-zinc-800 dark:bg-zinc-900/40">
        <div class="container-page reveal">
            <div class="max-w-2xl">
                <p class="eyebrow">Skills</p>
                <h2 class="section-title">Tools &amp; technologies</h2>
            </div>

            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($skillGroups as $group)
                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50/60 p-6 dark:border-zinc-800 dark:bg-zinc-950/40">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $group->name }}</h3>
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @foreach ($group->items ?? [] as $skill)
                                <span class="rounded-md border border-zinc-200 bg-white px-2.5 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($education->isNotEmpty())
                <h3 class="mt-16 text-xl font-bold text-zinc-900 dark:text-zinc-100">Education &amp; certifications</h3>
                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    @foreach ($education as $item)
                        <div class="card flex gap-4 p-6">
                            <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                <x-ui.icon name="graduation" class="size-5" />
                            </span>
                            <div>
                                <p class="text-xs font-semibold tracking-wide text-zinc-500 uppercase">{{ $item->type }} · {{ $item->period }}</p>
                                <p class="mt-1 font-semibold text-zinc-900 dark:text-zinc-100">{{ $item->title }}</p>
                                <p class="text-sm">{{ $item->institution }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="container-page reveal py-20">
        <div class="card grid overflow-hidden lg:grid-cols-[1fr_1.3fr]">
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-indigo-800 p-8 text-indigo-100 sm:p-10">
                <div aria-hidden="true" class="absolute -right-20 -bottom-20 size-64 rounded-full bg-white/10"></div>
                <div aria-hidden="true" class="absolute -top-10 -left-10 size-40 rounded-full bg-white/5"></div>
                <p class="text-sm font-semibold tracking-wide text-indigo-200 uppercase">Contact</p>
                <h2 class="mt-2 text-3xl font-bold text-white">Let's build something reliable together</h2>
                <p class="mt-4 leading-relaxed">Have a role, a project or an architecture challenge? Send me a message and I'll get back to you shortly.</p>

                <ul class="relative mt-10 space-y-5 text-sm">
                    @if ($profile->email)
                        <li><a href="mailto:{{ $profile->email }}" class="flex items-center gap-3 hover:text-white"><span class="grid size-10 place-items-center rounded-lg bg-white/10"><x-ui.icon name="mail" class="size-5" /></span>{{ $profile->email }}</a></li>
                    @endif
                    @if ($profile->phone)
                        <li><a href="tel:{{ preg_replace('/\s+/', '', $profile->phone) }}" class="flex items-center gap-3 hover:text-white"><span class="grid size-10 place-items-center rounded-lg bg-white/10"><x-ui.icon name="phone" class="size-5" /></span>{{ $profile->phone }}</a></li>
                    @endif
                    @if ($profile->location)
                        <li class="flex items-center gap-3"><span class="grid size-10 place-items-center rounded-lg bg-white/10"><x-ui.icon name="map-pin" class="size-5" /></span>{{ $profile->location }}</li>
                    @endif
                    @if ($profile->linkedin_url)
                        <li><a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" class="flex items-center gap-3 hover:text-white"><span class="grid size-10 place-items-center rounded-lg bg-white/10"><x-ui.icon name="linkedin" class="size-5" /></span>LinkedIn profile</a></li>
                    @endif
                </ul>
            </div>

            <div class="p-8 sm:p-10">
                @if (session('contact_sent'))
                    <div class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300" role="status">
                        <x-ui.icon name="check" class="size-5" /> Thanks! Your message has been sent.
                    </div>
                @endif
                @if (session('contact_expired'))
                    <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm font-medium text-amber-800 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300" role="alert">
                        Your session expired before the message was sent. Please press "Send message" again.
                    </div>
                @endif

                <form method="POST" action="{{ route('contact') }}" class="grid gap-5 sm:grid-cols-2">
                    @csrf
                    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                    <label class="block">
                        <span class="mb-1.5 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Full name</span>
                        <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="input">
                        @error('name')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block">
                        <span class="mb-1.5 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="input">
                        @error('email')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block sm:col-span-2">
                        <span class="mb-1.5 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Subject</span>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="input">
                    </label>
                    <label class="block sm:col-span-2">
                        <span class="mb-1.5 block text-sm font-medium text-zinc-800 dark:text-zinc-200">Message</span>
                        <textarea name="body" rows="5" required class="input">{{ old('body') }}</textarea>
                        @error('body')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <div class="sm:col-span-2">
                        <button type="submit" class="btn-primary w-full sm:w-auto"><x-ui.icon name="send" class="size-4" /> Send message</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout>
