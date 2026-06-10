<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public static function get(string $key, $default = null)
    {
        return static::all()->firstWhere('key', $key)->value ?? $default;
    }

    /** key => value map of every setting (used to share with all views) */
    public static function map(): array
    {
        return static::pluck('value', 'key')->toArray();
    }

    public static function put(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
