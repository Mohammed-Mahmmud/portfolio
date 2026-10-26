<x-layout :profile="$profile" title="All projects" description="A complete list of projects I've worked on.">
    <section class="container-page pt-16 pb-8">
        <a href="{{ route('home') }}#projects" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            <x-ui.icon name="arrow-left" class="size-4" /> Back to home
        </a>
        <p class="eyebrow mt-8">Archive</p>
        <h1 class="section-title !text-4xl sm:!text-5xl">All projects</h1>
        <p class="mt-4 max-w-2xl">A complete list of the platforms and products I've worked on over the past {{ $profile->years_experience }}+ years.</p>

        <div class="card mt-10 overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50 text-xs font-semibold tracking-wide text-zinc-500 uppercase dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3.5">Project</th>
                        <th class="hidden px-6 py-3.5 md:table-cell">Category</th>
                        <th class="hidden px-6 py-3.5 lg:table-cell">Built with</th>
                        <th class="px-6 py-3.5"><span class="sr-only">Link</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach ($projects as $project)
                        <tr class="group transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-6 py-4">
                                <a href="{{ route('projects.show', $project) }}" class="font-semibold text-zinc-900 group-hover:text-indigo-600 dark:text-zinc-100 dark:group-hover:text-indigo-400">{{ $project->title }}</a>
                                @if ($project->is_featured)<span class="chip-accent ml-2">Featured</span>@endif
                            </td>
                            <td class="hidden px-6 py-4 md:table-cell">{{ $project->category }}</td>
                            <td class="hidden px-6 py-4 lg:table-cell">
                                <div class="flex flex-wrap gap-1">
                                    @foreach (collect($project->tech_stack)->take(4) as $tech)
                                        <span class="chip">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ $project->url ?? route('projects.show', $project) }}" @if ($project->url) target="_blank" rel="noopener" @endif class="inline-flex text-zinc-400 hover:text-indigo-600" aria-label="Open {{ $project->title }}">
                                    <x-ui.icon :name="$project->url ? 'external' : 'arrow-right'" class="size-4" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-layout>
