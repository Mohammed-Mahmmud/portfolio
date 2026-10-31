<?php

namespace Database\Seeders\Concerns;

use App\Models\Project;

trait UpsertsProjects
{
    /**
     * Re-running refreshes the text but keeps the image, featured/visible flags and order set in the admin.
     * A new project is placed right after `$after`, shifting the projects below it down.
     */
    protected function upsertProject(string $slug, string $after, array $content): void
    {
        $project = Project::query()->firstWhere('slug', $slug);

        if ($project) {
            $project->update($content);

            return;
        }

        $anchor = Project::query()->firstWhere('slug', $after);
        $position = $anchor ? $anchor->sort_order + 1 : (int) Project::query()->max('sort_order') + 1;
        Project::query()->where('sort_order', '>=', $position)->increment('sort_order');

        Project::create($content + [
            'slug' => $slug,
            'sort_order' => $position,
            'is_featured' => false,
            'is_visible' => true,
        ]);
    }
}
