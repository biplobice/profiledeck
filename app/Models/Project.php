<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    public const KIND_PROFESSIONAL = 'professional';

    public const KIND_PERSONAL = 'personal';

    public const KIND_PACKAGE = 'package';

    protected $fillable = [
        'company_id',
        'name',
        'kind',
        'summary',
        'role',
        'responsibilities',
        'technologies',
        'url',
        'thumbnail_path',
        'started_on',
        'ended_on',
        'is_featured',
        'is_visible',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'started_on' => 'date',
            'ended_on' => 'date',
            'responsibilities' => 'array',
            'technologies' => 'array',
            'is_featured' => 'boolean',
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

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * @return array<string, string>
     */
    public static function kindLabels(): array
    {
        return [
            self::KIND_PROFESSIONAL => 'Professional',
            self::KIND_PERSONAL => 'Personal',
            self::KIND_PACKAGE => 'Package',
        ];
    }

    public function kindLabel(): string
    {
        return self::kindLabels()[$this->kind] ?? ucfirst($this->kind);
    }

    /**
     * Legacy thumbnails live under public/, uploads live on the public disk.
     */
    public function thumbnailUrl(): ?string
    {
        $path = $this->thumbnail_path;

        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (is_file(public_path($path))) {
            return asset(implode('/', array_map('rawurlencode', explode('/', $path))));
        }

        return Storage::disk('public')->url($path);
    }

    public function initials(): string
    {
        $words = preg_split('/[^\p{L}\p{N}]+/u', $this->name, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if ($words === []) {
            return '—';
        }

        if (count($words) === 1) {
            return Str::upper(Str::substr($words[0], 0, 2));
        }

        return Str::upper(Str::substr($words[0], 0, 1).Str::substr($words[1], 0, 1));
    }
}
