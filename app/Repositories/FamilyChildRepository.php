<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\FamilyChild;

class FamilyChildRepository extends ModuleRepository
{

    public function __construct(FamilyChild $model)
    {
        $this->model = $model;
    }
}
