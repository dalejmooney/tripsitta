<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\BookingStatus;
use Illuminate\Support\Collection;

class BookingController extends ModuleController
{
    protected $moduleName = 'bookings';
    protected $titleColumnKey = 'id';
    protected $titleFormKey = 'id';
    protected $defaultOrders = ['id' => 'desc'];

    protected $indexOptions = [
        'create' => false,
        'publish' => false,
        'restore' => false,
        'permalink' => false,
        'delete' => false,
        'bulkEdit' => false,
        'bulkDelete' => false,
    ];

    protected $indexWith = ['babysitter.user', 'family.user', 'bookingStatus', 'review'];
    protected $formWith = ['babysitter.user', 'family.user', 'bookingStatus', 'bookingChildren', 'bookingAddress', 'invoices'];

    protected $filters = ['booking_status' => 'booking_status'];

    protected $indexColumns = [
        'id' => [
            'title' => 'Booking ID',
            'field' => 'id',
            'sort' => true,
        ],
        'babysitter' => [
            'title' => 'Babysitter',
            'relationship' => 'babysitter.user',
            'field' => 'fullNameWithLink',
            'sort' => true,
        ],
        'parent' => [
            'title' => 'Parent',
            'relationship' => 'family.user',
            'field' => 'fullNameWithLink',
            'sort' => true,
        ],
        'booking_type' => [
            'title' => 'Booking type',
            'field' => 'type',
            'sort' => true,
        ],
        'start' => [
            'title' => 'Start',
            'field' => 'startDate',
            'sort' => true,
        ],
        'end' => [
            'title' => 'End',
            'field' => 'endDate',
            'sort' => true,
        ],
        'booking_status' => [
            'title' => 'Status',
            'relationship' => 'bookingStatus',
            'field' => 'name',
            'sort' => true,
        ],
        'created_at' => [
            'title' => 'Created at',
            'field' => 'createdDate',
            'sort' => true,
        ],
    ];

    protected $browserColumns = [
        'id' => [
            'title' => 'Booking ID',
            'field' => 'id',
        ],
    ];

    protected function indexData($request)
    {
        return [
            'booking_statusList' => BookingStatus::all()->pluck('name')->toArray(),
            'defaultFilterSlug' => 'upcoming',
        ];
    }

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
                'name' => 'Current',
                'slug' => 'current',
                'number' => $this->repository->getCountForCurrentBookings(),
            ],[
                'name' => 'Upcoming',
                'slug' => 'upcoming',
                'number' => $this->repository->getCountForUpcomingBookings(),
            ],[
                'name' => 'History',
                'slug' => 'history',
                'number' => $this->repository->getCountForHistoryBookings()
            ],[
                'name' => 'All',
                'slug' => 'all',
                'number' => $this->repository->getCountForAllBookings(),
            ]
        );

        return $statusFilters;
    }

    protected function getBrowserTableData($items)
    {
        $withImage = false; // changed only this. Rest is just copy

        return $items->map(function ($item) use ($withImage) {
            $columnsData = Collection::make($this->browserColumns)->mapWithKeys(function ($column) use ($item, $withImage) {
                return $this->getItemColumnData($item, $column);
            })->toArray();

            return [
                    'id' => $item->id,
                    'name' => $item->idPadded,
                    'edit' => moduleRoute($this->moduleName, $this->routePrefix, 'edit', $item->id),
                    'endpointType' => $this->repository->getMorphClass(),
                ] + $columnsData + ($withImage && !array_key_exists('thumbnail', $columnsData) ? [
                    'thumbnail' => $item->defaultCmsImage(['w' => 100, 'h' => 100]),
                ] : []);
        })->toArray();
    }
}
