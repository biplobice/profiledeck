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
        'about_photo_path',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }

    public function photoUrl(): ?string
    {
        return static::urlForPath($this->photo_path);
    }

    public function cvPhotoUrl(): ?string
    {
        return static::urlForPath($this->cv_photo_path);
    }

    public function aboutPhotoUrl(): ?string
    {
        return static::urlForPath($this->about_photo_path);
    }

    /**
     * @return array{src: string, width: ?int, height: ?int}|null
     */
    public function imageFor(?string $path): ?array
    {
        $src = static::urlForPath($path);

        if ($src === null) {
            return null;
        }

        $absolute = static::absolutePathFor($path);
        $size = $absolute ? @getimagesize($absolute) : false;

        return [
            'src' => $src,
            'width' => is_array($size) ? $size[0] : null,
            'height' => is_array($size) ? $size[1] : null,
        ];
    }

    public static function urlForPath(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (is_file(public_path($path))) {
            return asset(implode('/', array_map('rawurlencode', explode('/', $path))));
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return null;
    }

    public static function absolutePathFor(?string $path): ?string
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://'])) {
            return null;
        }

        $public = public_path($path);

        if (is_file($public)) {
            return $public;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->path($path);
        }

        return null;
    }
}
