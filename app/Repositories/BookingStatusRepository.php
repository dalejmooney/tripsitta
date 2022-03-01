<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\BookingStatus;

class BookingStatusRepository extends ModuleRepository
{

    public function __construct(BookingStatus $model)
    {
        $this->model = $model;
    }
}
