<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Messages\MessageResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortfolioStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected int|array|null $columns = 3;

    protected function getStats(): array
    {
        $weekly = Message::weeklyCounts();
        $thisWeek = end($weekly);
        $unread = Message::query()->whereNull('read_at')->count();

        $projects = Project::query();
        $current = Experience::query()->whereNull('end_date')->value('company');

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
            Stat::make('Experience', Profile::current()->yearsLabel().' years')
                ->description(Experience::query()->count().' positions'.($current ? ' · now at '.$current : ''))
                ->descriptionIcon(Heroicon::Briefcase),
        ];
    }
}
