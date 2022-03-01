<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Model;

class Slideshow extends Model
{
    use HasMedias, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'description',
        'colour'
    ];

    public $checkboxes = [
        'published'
    ];

    public $mediasParams = [
        'image' => [ // role name
            'default' => [ // crop name
                [
                    'name' => 'default', // ratio name, same as crop name if single
                    'ratio' => 16 / 9, // ratio as a fraction or number,
                    'minValues' => [
                        'width' => 1920,
                        'height' => 1080,
                    ],
                ],
            ],
        ],
    ];

    // --- relationships

    public function pages() {
        return $this->belongsTo('App\Models\Page');
    }
}
