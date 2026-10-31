<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\UpsertsProjects;
use Illuminate\Database\Seeder;

/**
 * Projects added after the original CV import.
 *
 * Safe to run on live data and safe to re-run: it only adds or updates these
 * specific projects and never deletes anything else.
 *
 * php artisan db:seed --class=AdditionalProjectsSeeder --force
 */
class AdditionalProjectsSeeder extends Seeder
{
    use UpsertsProjects;

    public function run(): void
    {
        $this->upsertProject('nile-future', after: 'stc-exam-system-nile-future', content: [
            'title' => 'Nile Future for Drilling',
            'category' => 'Oil & Gas',
            'url' => 'https://nilefuture.org',
            'summary' => 'Website for Nile Future, an onshore drilling and workover contractor — company overview, rig fleet, markets, clients and contact.',
            'tech_stack' => ['Laravel', 'Livewire'],
            'highlights' => [
                'Built the company website for an onshore drilling and workover contractor.',
                'Dedicated pages for the company overview, rig fleet, operating markets (including Indonesia) and clients.',
                'Interactive pages built with Laravel and Livewire.',
                'Contact flow for client and partner enquiries.',
            ],
        ]);
    }
}
