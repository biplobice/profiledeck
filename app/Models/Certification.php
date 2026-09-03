<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'name',
        'organization',
        'result',
        'awarded_on',
        'is_visible',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'awarded_on' => 'date',
            'is_visible' => 'boolean',
        ];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }
}
