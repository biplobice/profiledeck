<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'former_name',
        'website',
        'city',
        'country',
    ];

    /**
     * Roles that span a rebrand should credit both names.
     */
    public function displayName(): string
    {
        return $this->former_name
            ? $this->name.' (formerly '.$this->former_name.')'
            : $this->name;
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
