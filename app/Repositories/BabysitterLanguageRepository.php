<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\BabysitterLanguage;

class BabysitterLanguageRepository extends ModuleRepository
{

    public function __construct(BabysitterLanguage $model)
    {
        $this->model = $model;
    }
}
