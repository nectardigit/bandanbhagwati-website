<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'specs'       => 'array',
        'features'    => 'array',
        'gallery'     => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
