<x-layout :profile="$profile" :title="$project->title" :description="$project->summary">
    <article class="container-page pt-16 pb-8">
        <a href="{{ route('home') }}#projects" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            <x-ui.icon name="arrow-left" class="size-4" /> Back to projects
        </a>

        <div class="mt-8 grid gap-12 lg:grid-cols-[1.6fr_1fr]">
            <div>
                <p class="eyebrow">{{ $project->category }}</p>
                <h1 class="section-title !text-4xl sm:!text-5xl">{{ $project->title }}</h1>
                <p class="mt-6 text-lg leading-relaxed">{{ $project->summary }}</p>

                @if ($project->image)
                    <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }} screenshot" class="mt-10 w-full rounded-2xl border border-zinc-200 shadow-lg dark:border-zinc-800">
                @endif

                @if (! empty($project->highlights))
                    <h2 class="mt-12 text-2xl font-bold text-zinc-900 dark:text-zinc-100">Key highlights</h2>
                    <ul class="mt-6 grid gap-3">
                        @foreach ($project->highlights as $item)
                            <li class="card flex gap-4 p-5 leading-relaxed">
                                <span class="grid size-7 shrink-0 place-items-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400"><x-ui.icon name="check" class="size-4" /></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                @if (! empty($project->tech_stack))
                    <div class="card p-6">
                        <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Tech stack</h2>
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @foreach ($project->tech_stack as $tech)
                                <span class="chip-accent">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card p-6">
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Interested in something similar?</h2>
                    <p class="mt-2 text-sm">I'm happy to walk through the architecture and decisions behind this project.</p>
                    <div class="mt-5 grid gap-2">
                        @if ($project->url)
                            <a href="{{ $project->url }}" target="_blank" rel="noopener" class="btn-secondary"><x-ui.icon name="external" class="size-4" /> Visit live site</a>
                        @endif
                        <a href="{{ route('home') }}#contact" class="btn-primary"><x-ui.icon name="send" class="size-4" /> Get in touch</a>
                    </div>
                </div>
            </aside>
        </div>
    </article>
</x-layout>
