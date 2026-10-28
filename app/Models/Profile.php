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
            'years_experience_plus' => 'boolean',
        ];
    }

    /**
     * Years of experience as displayed, e.g. "6+" or "6".
     */
    public function yearsLabel(): string
    {
        return $this->years_experience.($this->years_experience_plus ? '+' : '');
    }

    public static function current(): self
    {
        return static::query()->firstOrNew([], ['name' => config('app.name'), 'title' => '']);
    }
}
