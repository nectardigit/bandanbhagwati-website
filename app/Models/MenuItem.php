<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'open_new_tab' => 'boolean',
        'is_active'    => 'boolean',
    ];

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->where('is_active', true)->orderBy('sort');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /** Resolved destination URL: a custom link, or the linked page's URL. */
    public function getLinkAttribute(): string
    {
        if ($this->type === 'page' && $this->page) {
            return url('/'.$this->page->slug);
        }

        return $this->url ?: '#';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
