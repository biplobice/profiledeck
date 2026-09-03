<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'employment_type',
        'started_on',
        'ended_on',
        'summary',
        'responsibilities',
        'achievements',
        'is_visible',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'started_on' => 'date',
            'ended_on' => 'date',
            'responsibilities' => 'array',
            'achievements' => 'array',
            'is_visible' => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    public function periodLabel(): string
    {
        $start = $this->started_on?->format('M Y') ?? '';
        $end = $this->ended_on ? $this->ended_on->format('M Y') : 'Present';

        return trim("{$start} – {$end}");
    }
}
