<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    protected $casts = [
        'show_in_solutions' => 'boolean',
        'show_in_accordion' => 'boolean',
        'is_active'         => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
