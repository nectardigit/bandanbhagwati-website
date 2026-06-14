<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }
}
