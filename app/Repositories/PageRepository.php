<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Babysitter;
use App\Models\Page;

class PageRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $belongsToModels = $object->slideshows;
        if ($belongsToModels) {
            foreach ($belongsToModels as $belongsToModel) {
                $fields['browsers']['slider'][] =
                    [
                        'id' => $belongsToModel->id,
                        'name' => $belongsToModel->title,
                        'thumbnail' => $belongsToModel->defaultCmsImage(['w' => 100, 'h' => 100]),
                        'edit' => moduleRoute('slideshows', 'cms', 'edit', $belongsToModel->id),
                    ];
            }
        }

        return $fields;
    }

    public function updateOneToManyBrowser($object, $fields, $relationship, $formField, $attribute, $related_modal)
    {
        if (isset($fields[$formField])) {
            foreach ($fields[$formField] as $i => $browserfield) {
                $related_object = $related_modal::find($browserfield['id']);
                $related_object->$attribute = $object->id;
                $related_object->position = ++$i;
                $related_object->save();
                $related_object_ids[] = $related_object->id;
            }
            foreach ($object->$relationship as $related_item) {
                if (!in_array($related_item->id, $related_object_ids)) {
                    $related_item->$attribute = null;
                    $related_item->save();
                }
            }
        } else {
            foreach ($object->$relationship as $related_item) {
                $related_item->$attribute = null;
                $related_item->save();
            }
        }
    }
    public function afterSave($object, $fields) {
        if(isset($fields['browsers']))
        {
            $this->updateOneToManyBrowser($object, $fields['browsers'], 'slideshows', 'slider', 'page_id', \App\Models\Slideshow::class);
        }

        parent::afterSave($object, $fields);
    }
}
