<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_remote' => 'boolean',
            'is_visible' => 'boolean',
            'highlights' => 'array',
            'tech_stack' => 'array',
        ];
    }

    #[Scope]
    protected function visible(Builder $query): void
    {
        $query->where('is_visible', true)->orderBy('sort_order')->orderByDesc('start_date');
    }

    public function period(): string
    {
        return $this->start_date->format('M Y').' — '.($this->end_date?->format('M Y') ?? 'Present');
    }
}
