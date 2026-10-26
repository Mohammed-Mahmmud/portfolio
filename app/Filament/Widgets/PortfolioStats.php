<?php

namespace App\Filament\Widgets;

use App\Models\Experience;
use App\Models\Message;
use App\Models\Project;
use App\Models\SkillGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortfolioStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Projects', Project::query()->count())
                ->description(Project::query()->where('is_featured', true)->count().' featured')
                ->descriptionIcon(Heroicon::Star),
            Stat::make('Experiences', Experience::query()->count()),
            Stat::make('Skills', SkillGroup::query()->get()->sum(fn (SkillGroup $group) => count($group->items ?? []))),
            Stat::make('Unread messages', Message::query()->whereNull('read_at')->count())
                ->description(Message::query()->count().' total')
                ->descriptionIcon(Heroicon::Inbox)
                ->color('primary'),
        ];
    }
}
