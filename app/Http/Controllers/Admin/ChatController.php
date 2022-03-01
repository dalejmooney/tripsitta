<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class ChatController extends ModuleController
{
    protected $moduleName = 'chats';

    protected $titleColumnKey = 'id';
    protected $titleFormKey = 'id';
    protected $indexWith = ['sender', 'recipient', 'messages', 'booking'];
    protected $formWith = ['sender', 'recipient', 'messages'];

    protected $indexOptions = [
        'create' => false,
        'publish' => false,
        'restore' => false,
        'permalink' => false,
        'delete' => false,
        'bulkEdit' => false,
        'bulkDelete' => false,
    ];

    protected $indexColumns = [
        'id' => [
            'title' => 'Chat ID',
            'field' => 'id',
            'sort' => true,
        ],
        'sender' => [
            'title' => 'Sender',
            'relationship' => 'sender',
            'field' => 'fullNameWithLink',
            'sort' => true,
        ],
        'recipient' => [
            'title' => 'Recipient',
            'relationship' => 'recipient',
            'field' => 'fullNameWithLink',
            'sort' => true,
        ],
        'booking' => [
            'title' => 'Booking id',
            'relationship' => 'booking',
            'field' => 'idPaddedWithLink',
            'sort' => true,
        ],
        'last_message' => [
            'title' => 'Last messaged',
            'field' => 'lastMessageDate',
            'sort' => true,
        ],
    ];

    protected function formData($request)
    {
        return [
            'editableTitle' => false, // disable editing title, it's static
            'permalink' => false,
        ];
    }

    public function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = [];

        array_push($statusFilters,
            [
                'name' => 'All chats',
                'slug' => 'all',
                'number' => $this->repository->getCountForAll(),
            ],
            [
                'name' => 'Can reply',
                'slug' => 'can-reply',
                'number' => $this->repository->getCountForAdminChats(),
            ]
        );

        return $statusFilters;
    }
}
