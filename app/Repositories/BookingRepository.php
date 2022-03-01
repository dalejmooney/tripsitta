<?php

namespace App\Repositories;


use A17\Twill\Repositories\Behaviors\HandleBrowsers;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Booking;
use App\Models\BookingStatus;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

class BookingRepository extends ModuleRepository
{
    use HandleRepeaters, HandleBrowsers;

    public function __construct(Booking $model)
    {
        $this->model = $model;
    }

    public function filter($query, array $scopes = []) {
        // booking status filter
        if (isset($scopes['booking_status'])) {
            $query->whereHas('bookingStatus', function ($query) use($scopes) {
                $query->where('name', $scopes['booking_status']);
            });
            unset($scopes['booking_status']);
        }

        //search
        if (isset($scopes['%id'])) {
            $query->where(function($q) use($scopes){
                $q->whereHas('babysitter.user', function ($q) use($scopes) {
                    $q->where('name', 'like', '%'.$scopes['%id'].'%')->orWhere('surname', 'like', '%'.$scopes['%id'].'%');
                })->orWhereHas('family.user', function ($q) use($scopes) {
                    $q->where('name', 'like', '%'.$scopes['%id'].'%')->orWhere('surname', 'like', '%'.$scopes['%id'].'%');
                })->orWhere('id', $scopes['%id']);
            });

            unset($scopes['%id']);
        }

        $filter_status = '';
        $filter = (array_key_exists('filter', request()->input())) ? json_decode(request()->input()['filter'], true) : null;

        if(is_array($filter) && array_key_exists('status', $filter)){
            $filter_status = $filter['status'];
        }

        if($filter_status !== '')
        {
            if($filter_status === 'current')
            {
                $query->whereDate('start', '>=', date('Y-m-d H:i:s'))->whereDate('end', '<=', date('Y-m-d H:i:s'));
            }
            elseif($filter_status === 'upcoming')
            {
                $query->whereDate('start', '>=', date('Y-m-d H:i:s'));
            }
            elseif($filter_status === 'history')
            {
                $query->whereDate('end', '<', date('Y-m-d H:i:s'));
            }
        }
        else
        {
           //$query->whereDate('start', '>=', date('Y-m-d H:i:s'));
        }

        return parent::filter($query, $scopes);
    }

    public function getFormFields($object) {
        $fields = parent::getFormFields($object);

        $fields['status'] = $object->bookingStatus->name;
        $fields['statusList'] = app(BookingStatusRepository::class)->listAll('name');

        $fields['babysitter'] = $object->babysitter->toArray();
        $fields['babysitter']['user'] = $object->babysitter->user->toArray();
        $fields['babysitter']['count_prev_bookings'] = $object->babysitter->bookings->count() - 1;
        $fields['babysitter']['reviews'] = $object->babysitter->reviewsAverage;
        $fields['babysitter']['reviews_count'] = $object->babysitter->ReviewsNumber;

        $fields['family'] = $object->family->toArray();
        $fields['family']['user'] = $object->family->user->toArray();
        $fields['family']['count_prev_bookings'] = $object->family->bookings->count() - 1;

        $fields['booking_duration'] = Carbon::parse($object->start)->diffForHumans($object->end, ['parts' => 4, 'syntax' => CarbonInterface::DIFF_ABSOLUTE]);
        $fields['booking_children'] = $object->bookingChildren->toArray();

        $fields['booking_address'] = $object->bookingAddress ? $object->bookingAddress->toArray() : null;
        $fields['invoices'] = $object->invoices ? $object->invoices : null;

        return $fields;
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        $fields = parent::prepareFieldsBeforeSave($object, $fields);

        if((int) $fields['status_id'] !== (int) $object->status_id) // admin changed status
        {
            if(in_array((int) $fields['status_id'], [2,3,5])) // new status is final
            {
                $fields['completed_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                $fields['parent_completed_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                $fields['babysitter_completed_at'] = (new \DateTime())->format('Y-m-d H:i:s');
            }
        }

        return $fields;
    }

    /**
     * @return int
     */
    public function getCountForAllBookings()
    {
        return $this->model->count();
    }

    /**
     * @return int
     */
    public function getCountForUpcomingBookings()
    {
        return $this->model->whereDate('start', '>=', date('Y-m-d H:i:s'))->count();
    }

    /**
     * @return int
     */
    public function getCountForCurrentBookings()
    {
        return $this->model->whereDate('start', '>=', date('Y-m-d H:i:s'))->whereDate('end', '<=', date('Y-m-d H:i:s'))->count();
    }

    /**
     * @return int
     */
    public function getCountForHistoryBookings()
    {
        return $this->model->whereDate('end', '<', date('Y-m-d H:i:s'))->count();
    }
}
