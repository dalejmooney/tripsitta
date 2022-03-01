<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Slideshow;

class SlideshowRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(Slideshow $model)
    {
        $this->model = $model;
    }
}
