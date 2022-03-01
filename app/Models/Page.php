<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;

class Page extends Model
{
    use HasBlocks, HasSlug, HasMedias;

    protected $fillable = [
        'published',
        'title',
        'subtitle',
        'content',
        'system_hook',
        'meta_title',
        'meta_desc'
    ];

     public $slugAttributes = [
         'title',
     ];

    // add checkbox fields names here (published toggle is itself a checkbox)
    public $checkboxes = [
        'published'
    ];

    // --- relationships

    public function slideshows() {
        return $this->hasMany('App\Models\Slideshow')->orderBy('position');
    }

    // --- scopes

    public function scopeForHook($query, $hook_name)
    {
        return $query->where('system_hook', $hook_name);
    }
}
