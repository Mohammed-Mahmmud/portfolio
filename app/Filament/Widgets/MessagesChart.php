<?php

namespace App\Filament\Widgets;

use App\Filament\Support\ChartStyle;
use App\Models\Message;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MessagesChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Messages received';

    protected ?string $description = 'Contact form submissions per week, last 12 weeks';

    protected ?string $maxHeight = '340px';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $weekly = Message::weeklyCounts();

        return [
            'datasets' => [
                [
                    'label' => 'Messages',
                    'data' => array_values($weekly),
                    'borderColor' => ChartStyle::ACCENT,
                    'backgroundColor' => ChartStyle::ACCENT_WASH,
                    'fill' => 'origin',
                    'borderWidth' => 2,
                    'tension' => 0,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                    'pointBackgroundColor' => ChartStyle::ACCENT,
                    'pointBorderWidth' => 0,
                ],
            ],
            'labels' => array_map(fn (string $week) => Carbon::parse($week)->format('M j'), array_keys($weekly)),
        ];
    }

    protected function getOptions(): array
    {
        return ChartStyle::options([
            'scales' => [
                'x' => ['ticks' => ['maxRotation' => 0, 'autoSkip' => true, 'maxTicksLimit' => 6]],
                'y' => ['ticks' => ['precision' => 0]],
            ],
        ]);
    }
}
