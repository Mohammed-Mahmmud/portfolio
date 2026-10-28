<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Message extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'body'];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'replied_at' => 'datetime',
        ];
    }

    /**
     * Messages received per week, oldest first, keyed by the week's start date.
     *
     * @return array<string, int>
     */
    public static function weeklyCounts(int $weeks = 12): array
    {
        $start = Carbon::now()->startOfWeek()->subWeeks($weeks - 1);

        $counts = array_fill_keys(
            collect(range(0, $weeks - 1))->map(fn (int $i) => $start->copy()->addWeeks($i)->toDateString())->all(),
            0,
        );

        static::query()
            ->where('created_at', '>=', $start)
            ->pluck('created_at')
            ->each(function (Carbon $date) use (&$counts) {
                $counts[$date->copy()->startOfWeek()->toDateString()]++;
            });

        return $counts;
    }
}
