<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SkillGroup extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'is_visible' => 'boolean',
        ];
    }

    #[Scope]
    protected function visible(Builder $query): void
    {
        $query->where('is_visible', true)->orderBy('sort_order');
    }
}
