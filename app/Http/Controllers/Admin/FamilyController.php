<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class FamilyController extends ModuleController
{
    protected $moduleName = 'families';
    protected $titleColumnKey = 'userFullname';
    protected $titleFormKey = 'fullname';
    protected $defaultOrders = ['id' => 'asc'];

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
        'phone' => [
            'title' => 'Phone',
            'relationship' => 'user',
            'field' => 'phone_number',
        ],
    ];

    protected $indexWith = ['user'];
    protected $formWith = ['user'];

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
}
