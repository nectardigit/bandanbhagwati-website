<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'specs'     => 'array',
        'gallery'   => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
