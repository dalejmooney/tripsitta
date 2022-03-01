<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class SlideshowController extends ModuleController
{
    protected $moduleName = 'slideshows';
    protected $indexOptions = [
        'permalink' => false,
    ];

    protected function getBrowserItems($scopes = [])
    {
        $scopes = ['published' => 1];
        return $this->getIndexItems($scopes, true);
    }
}
