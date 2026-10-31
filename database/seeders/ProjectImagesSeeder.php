<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Gives projects a screenshot of their live site, from database/seeders/project-images/<slug>.jpg.
 *
 * Only fills projects that have no image yet, so images uploaded in the admin are never replaced.
 * Safe to re-run.
 *
 * php artisan db:seed --class=ProjectImagesSeeder --force
 */
class ProjectImagesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (glob(database_path('seeders/project-images/*.jpg')) as $file) {
            $slug = pathinfo($file, PATHINFO_FILENAME);
            $project = Project::query()->firstWhere('slug', $slug);

            if (! $project || filled($project->image)) {
                continue;
            }

            $path = 'projects/'.$slug.'.jpg';
            Storage::disk('public')->put($path, file_get_contents($file));
            $project->update(['image' => $path]);

            $this->command?->info("Image added: {$project->title}");
        }
    }
}
