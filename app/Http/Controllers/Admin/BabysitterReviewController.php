<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use A17\Twill\Models\Behaviors\HasRelated;

class BabysitterReviewController extends ModuleController
{
    use HasRelated;

    protected $moduleName = 'babysitterReviews';
    protected $defaultOrders = ['id' => 'desc'];

    protected $indexOptions = [
        'permalink' => false,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
        'score' => [
            'title' => 'Score',
            'field' => 'score',
            'sort' => true,
        ],
        'id' => [
            'title' => 'Babysitter ID',
            'relationship' => 'babysitter',
            'field' => 'id',
            'visible' => false
        ],
        'fullname' => [
            'title' => 'Babysitter name',
            'relationship' => 'babysitter.user',
            'field' => 'fullNameWithLink',
        ],
    ];

    protected $indexWith = ['babysitter.user'];
    protected $formWith = ['babysitter.user', 'booking'];
}
