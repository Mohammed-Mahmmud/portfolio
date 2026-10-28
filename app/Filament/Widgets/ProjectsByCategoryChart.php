<?php

namespace App\Filament\Widgets;

use App\Filament\Support\ChartStyle;
use App\Models\Project;
use Filament\Widgets\ChartWidget;

class ProjectsByCategoryChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Projects by category';

    protected ?string $description = 'A project can belong to more than one category';

    protected ?string $maxHeight = '340px';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $counts = Project::query()->pluck('category')
            ->flatMap(fn (?string $category) => array_map('trim', explode('·', (string) $category)))
            ->filter()
            ->countBy()
            ->sortDesc();

        // Every category gets its own row; folding the long tail into "Other" made that bar
        // the tallest and misrepresented the mix.
        $top = $counts->take(16);

        return [
            'datasets' => [
                [
                    'label' => 'Projects',
                    'data' => $top->values()->all(),
                    'backgroundColor' => ChartStyle::ACCENT,
                    'hoverBackgroundColor' => ChartStyle::ACCENT_HOVER,
                    'borderWidth' => 0,
                    'borderRadius' => 4,
                    'borderSkipped' => 'start',
                    'maxBarThickness' => 14,
                ],
            ],
            'labels' => $top->keys()->all(),
        ];
    }

    protected function getOptions(): array
    {
        return ChartStyle::options([
            'indexAxis' => 'y',
            'scales' => [
                'x' => ['ticks' => ['precision' => 0]],
                'y' => ['grid' => ['display' => false], 'ticks' => ['autoSkip' => false]],
            ],
        ]);
    }
}
