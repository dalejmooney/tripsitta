<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Mail\AccountActivatedBabysitter;
use App\Mail\AccountDeactivatedBabysitter;
use App\Models\Babysitter;
use App\User;
use Illuminate\Support\Collection;

class BabysitterController extends ModuleController
{
    protected $moduleName = 'babysitters';
    protected $titleColumnKey = 'userFullname';
    protected $titleFormKey = 'fullname';
    protected $defaultOrders = ['id' => 'desc'];

    protected $indexColumns = [
        'userFullname' => [
            'title' => 'Name',
            'relationship' => 'user',
            'field' => 'fullname',
            'sort' => true,
        ],
        'email' => [
            'title' => 'Email',
            'relationship' => 'user',
            'field' => 'email',
            'sort' => true,
        ],
        'completedRegistrationAsIcon' => [
            'title' => 'Reg Completed',
            'field' => 'completedRegistrationAsIcon',
            'sort' => true,
        ],
        'validIdAsIcon' => [
            'title' => 'Valid ID',
            'field' => 'validIdAsIcon',
            'sort' => true,
        ],
        'ValidQualificationsAsIcon' => [
            'title' => 'Valid Qualifications',
            'field' => 'ValidQualificationsAsIcon',
            'sort' => true,
        ],
        'ValidReferencesAsIcon' => [
            'title' => 'Valid References',
            'field' => 'ValidReferencesAsIcon',
            'sort' => true,
        ],
        'SuccessfulInterviewAsIcon' => [
            'title' => 'Successful Interview',
            'field' => 'SuccessfulInterviewAsIcon',
            'sort' => true,
        ],
        'phone' => [
            'title' => 'Phone',
            'relationship' => 'user',
            'field' => 'phone_number',
        ],
        'score' => [
            'title' => 'Reviews score',
            'field' => 'reviewsAverage',
            'sort' => true,
        ],
        'score_count' => [
            'title' => 'Reviews count',
            'field' => 'reviewsNumber',
            'sort' => true,
        ],
    ];

    protected $browserColumns = [
        'userFullname' => [
            'title' => 'Full name',
            'relationship' => 'user',
            'field' => 'fullname',
        ],
    ];

    protected $indexWith = ['user'];
    protected $formWith = ['user', 'mainAddress', 'bank'];

    protected function indexData($request)
    {
        return [
            'defaultFilterSlug' => 'published',
            'customPublishedLabel' => 'Enabled',
            'customDraftLabel' => 'Disabled',
        ];
    }

    protected function formData($request)
    {
        return [
            'editableTitle' => false, // disable editing title, it's static
            'permalink' => false,
            'customPublishedLabel' => 'Enabled',
            'customDraftLabel' => 'Disabled',
        ];
    }

    public function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = [];

        array_push($statusFilters, [
            'name' => 'New',
            'slug' => 'new',
            'number' => $this->repository->getCountForNew(),
        ], [
            'name' => 'Active',
            'slug' => 'published',
            'number' => $this->repository->getCountByStatusSlug('published'),
        ], [
            'name' => 'Disabled',
            'slug' => 'draft',
            'number' => $this->repository->getCountByStatusSlug('draft'),
        ]);

        if ($this->getIndexOption('restore')) {
            array_push($statusFilters, [
                'name' => 'Trash',
                'slug' => 'trash',
                'number' => $this->repository->getCountByStatusSlug('trash'),
            ]);
        }

        return $statusFilters;
    }

    protected function getRequestFilters()
    {
        return json_decode($this->request->get('filter'), true) ?? ['status' => 'published'];
    }

    protected function getBrowserTableData($items)
    {
        $withImage = false; // changed only this. Rest is just copy

        return $items->map(function ($item) use ($withImage) {
            $columnsData = Collection::make($this->browserColumns)->mapWithKeys(function ($column) use ($item, $withImage) {
                return $this->getItemColumnData($item, $column);
            })->toArray();

            $name = $columnsData[$this->titleColumnKey];
            unset($columnsData[$this->titleColumnKey]);

            return [
                    'id' => $item->id,
                    'name' => $name,
                    'edit' => moduleRoute($this->moduleName, $this->routePrefix, 'edit', $item->id),
                    'endpointType' => $this->repository->getMorphClass(),
                ] + $columnsData + ($withImage && !array_key_exists('thumbnail', $columnsData) ? [
                    'thumbnail' => $item->defaultCmsImage(['w' => 100, 'h' => 100]),
                ] : []);
        })->toArray();
    }

    public function publish()
    {
        // Fire email confirmation for activation / deactivation of account
        $user = User::with(['babysitter'])->findOrFail($this->request->get('id'));
        if(!$this->request->get('active')){
            \Mail::to($user->email)->send(new AccountActivatedBabysitter($user->name));
        }
        else
        {
            \Mail::to($user->email)->send(new AccountDeactivatedBabysitter($user->name));
        }

        return parent::publish();
    }
}
