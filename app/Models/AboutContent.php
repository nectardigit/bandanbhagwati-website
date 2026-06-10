<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features' => 'array',
    ];

    /** The single about-content row (created if missing). */
    public static function singleton(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
