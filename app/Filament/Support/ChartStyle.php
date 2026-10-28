<?php

namespace App\Filament\Support;

/**
 * Shared look for dashboard charts: one accent hue, thin marks, hairline grid.
 */
class ChartStyle
{
    // Filament's primary (teal-500), so charts match the panel.
    public const ACCENT = '#14b8a6';

    public const ACCENT_HOVER = '#0d9488';

    public const ACCENT_WASH = 'rgba(20, 184, 166, 0.1)';

    // Neutral gray at low opacity reads as a hairline on both light and dark surfaces.
    public const GRID = 'rgba(128, 128, 128, 0.15)';

    public static function options(array $overrides = []): array
    {
        return array_replace_recursive([
            'maintainAspectRatio' => false,
            'interaction' => ['mode' => 'index', 'intersect' => false],
            'plugins' => [
                // Single series: the heading names it, so a legend box adds nothing.
                'legend' => ['display' => false],
                'tooltip' => ['displayColors' => false, 'padding' => 10],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['color' => self::GRID, 'drawTicks' => false],
                    'border' => ['display' => false],
                    'ticks' => ['padding' => 8],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => ['color' => self::GRID, 'drawTicks' => false],
                    'border' => ['display' => false],
                    'ticks' => ['padding' => 8],
                ],
            ],
        ], $overrides);
    }
}
