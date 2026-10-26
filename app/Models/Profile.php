<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'stats' => 'array',
            'expertise' => 'array',
            'available_for_work' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrNew([], ['name' => config('app.name'), 'title' => '']);
    }
}
