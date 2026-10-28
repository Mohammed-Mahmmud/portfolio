<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Messages\MessageResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortfolioStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $weekly = Message::weeklyCounts();
        $thisWeek = end($weekly);
        $unread = Message::query()->whereNull('read_at')->count();

        $projects = Project::query();
        $current = Experience::query()->whereNull('end_date')->value('company');
        $skillGroups = SkillGroup::query()->get();

        return [
            Stat::make('Unread messages', $unread)
                ->description($thisWeek.' received this week')
                ->descriptionIcon(Heroicon::Inbox)
                ->chart(array_values($weekly))
                ->color($unread > 0 ? 'primary' : 'gray')
                ->url(MessageResource::getUrl()),
            Stat::make('Projects', (clone $projects)->count())
                ->description((clone $projects)->where('is_featured', true)->count().' featured · '.(clone $projects)->where('is_visible', false)->count().' hidden')
                ->descriptionIcon(Heroicon::Star)
                ->url(ProjectResource::getUrl()),
            Stat::make('Experience', (Profile::query()->value('years_experience') ?? 0).'+ years')
                ->description(Experience::query()->count().' positions'.($current ? ' · now at '.$current : ''))
                ->descriptionIcon(Heroicon::Briefcase),
            Stat::make('Skills', $skillGroups->sum(fn (SkillGroup $group) => count($group->items ?? [])))
                ->description('across '.$skillGroups->count().' groups')
                ->descriptionIcon(Heroicon::CpuChip),
        ];
    }
}
