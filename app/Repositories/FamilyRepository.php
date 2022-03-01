<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Family;

class FamilyRepository extends ModuleRepository
{
    use HandleFiles, HandleRepeaters;

    public function __construct(Family $model)
    {
        $this->model = $model;
    }

    public function getFormFields($object) {
        $fields = parent::getFormFields($object);

        $fields['user'] = $object->user->toArray();
        $fields['fullname'] = $object->user->fullname;

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'children', 'FamilyChild', 'child');

        return $fields;
    }

    public function afterSave($object, $fields)
    {
        $this->updateRepeater($object, $fields, 'children', 'FamilyChild', 'child');

        parent::afterSave($object, $fields);
    }
}
