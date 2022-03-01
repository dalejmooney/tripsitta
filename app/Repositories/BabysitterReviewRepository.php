<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\BabysitterReview;

class BabysitterReviewRepository extends ModuleRepository
{
    public function __construct(BabysitterReview $model)
    {
        $this->model = $model;
    }

    public function getFormFields($object) {
        $fields = parent::getFormFields($object);
        if($object->babysitter)
        {
            $fields['browsers']['babysitter'][0] = [
                'id' => $object->babysitter->id,
                'name' => $object->babysitter->user->fullName,
                'edit' => moduleRoute('babysitters', 'b', 'edit', $object->babysitter->id),
                'endpointType' => $object->babysitter->getMorphClass(),
            ];
        }

        $belongsToModel = $object->booking;
        if ($belongsToModel) {
            $fields['browsers']['booking'] = collect([
                [
                    'id' => $belongsToModel->id,
                    'name' => $belongsToModel->idPadded,
                    'edit' => moduleRoute('bookings', '', 'edit', $belongsToModel->id),
                ],
            ])->toArray();
        }

        return $fields;
    }

    public function filter($query, array $scopes = []) {
        //search
        if (isset($scopes['%title'])) {
            if (strpos($scopes['%title'], 'id:') === 0) {
                $id = explode(':', $scopes['%title']);

                $query->whereHas('babysitter.user', function ($q) use($id) {
                    $q->where('id', $id[1]);
                });
            }
            else
            {
                $query->where(function($q) use($scopes){
                    $q->whereHas('babysitter.user', function ($q) use($scopes) {
                        $q->where('name', 'like', '%'.$scopes['%title'].'%')->orWhere('surname', 'like', '%'.$scopes['%title'].'%');
                    });
                });
            }

            unset($scopes['%title']);
        }

        return parent::filter($query, $scopes);
    }

    public function afterSave($object, $fields)
    {
        $relationship = 'babysitter';
        $fieldsHasElements = isset($fields['browsers']['babysitter']) && !empty($fields['browsers']['babysitter']);
        $relatedElements = $fieldsHasElements ? $fields['browsers']['babysitter'] : [];

        if($relatedElements)
        {
            $object->babysitter_id = $relatedElements[0]['id'];
            $object->save();
        }

        $relationship = 'bookings';
        $fieldsHasElements = isset($fields['browsers']['booking']) && !empty($fields['browsers']['booking']);
        $relatedElements = $fieldsHasElements ? $fields['browsers']['booking'] : [];

        if($relatedElements)
        {
            $object->booking_id = $relatedElements[0]['id'];
            $object->save();
        }

        parent::afterSave($object, $fields);
    }
}
