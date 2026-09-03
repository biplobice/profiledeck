<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
