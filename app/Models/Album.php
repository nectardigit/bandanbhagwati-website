<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images'    => 'array',
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

    /** All photos: cover first (if set), then the gallery images, de-duplicated. */
    public function photos(): array
    {
        $imgs = is_array($this->images) ? $this->images : [];
        if ($this->cover) {
            array_unshift($imgs, $this->cover);
        }

        return array_values(array_unique(array_filter($imgs)));
    }
}
