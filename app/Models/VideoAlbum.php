<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoAlbum extends Model
{
    protected $guarded = [];

    protected $casts = [
        'videos'    => 'array',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function videoList(): array
    {
        return is_array($this->videos) ? array_values(array_filter($this->videos, fn ($v) => ! empty($v['url']))) : [];
    }
}
