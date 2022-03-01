<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;

class Post extends Model
{
    use HasSlug, HasMedias, HasBlocks;

    protected $fillable = [
        'published',
        'title',
        'description',
        // 'position',
        // 'public',
        // 'featured',
        // 'publish_start_date',
        // 'publish_end_date',
    ];

     public $slugAttributes = [
         'title',
     ];

    // add checkbox fields names here (published toggle is itself a checkbox)
    public $checkboxes = [
        'published'
    ];

    public $mediasParams = [
        'thumbnail' => [ // role name
            'default' => [ // crop name
                [
                    'name' => 'square', // ratio name, same as crop name if single
                    'ratio' => 1/1, // ratio as a fraction or number,
                    'minValues' => [
                        'width' => 600,
                        'height' => 600,
                    ],
                ],
            ],
        ],
    ];
}
