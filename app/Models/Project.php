<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'tech_stack' => 'array',
            'is_featured' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            $project->slug = $project->slug ?: Str::slug($project->title);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    #[Scope]
    protected function visible(Builder $query): void
    {
        $query->where('is_visible', true)->orderBy('sort_order');
    }
}
