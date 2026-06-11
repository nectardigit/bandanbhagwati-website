<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    protected $guarded = [];

    /** The single home-content row (created if missing). */
    public static function singleton(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
