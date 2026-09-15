<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'headline',
        'tagline',
        'summary',
        'bio',
        'location',
        'email',
        'phone',
        'website',
        'blog_url',
        'github_url',
        'linkedin_url',
        'twitter_url',
        'photo_path',
        'cv_photo_path',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }

    public function photoUrl(): ?string
    {
        $path = $this->photo_path;

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
}
