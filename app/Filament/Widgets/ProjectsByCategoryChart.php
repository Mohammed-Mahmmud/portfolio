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

    protected ?string $maxHeight = '260px';

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

        // Keep the chart readable: the long tail folds into "Other".
        $top = $counts->take(7);
        if ($counts->count() > 7) {
            $top->put('Other', $counts->slice(7)->sum());
        }

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
                    'maxBarThickness' => 24,
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
                'y' => ['grid' => ['display' => false]],
            ],
        ]);
    }
}
