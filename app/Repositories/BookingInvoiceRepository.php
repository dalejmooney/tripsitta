<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\BookingInvoice;

class BookingInvoiceRepository extends ModuleRepository
{
    public function __construct(BookingInvoice $model)
    {
        $this->model = $model;
    }

    public function filter($query, array $scopes = [])
    {
        //search
        if (isset($scopes['%id'])) {
            $query->where(function ($q) use ($scopes) {
                $q->where('reference', 'like', '%' . $scopes['%id'] . '%')->orWhere('booking_id', 'like', '%' . $scopes['%id'] . '%');
            });

            unset($scopes['%id']);
        }

        $filter_status = '';
        $filter = (array_key_exists('filter', request()->input())) ? json_decode(request()->input()['filter'], true) : null;

        if(is_array($filter) && array_key_exists('status', $filter)){
            $filter_status = $filter['status'];
        }

        if($filter_status === 'paid')
        {
            $query->whereColumn('amount_due', 'amount_paid');
        }
        elseif($filter_status === 'unpaid')
        {
            $query->whereColumn('amount_due', '<>', 'amount_paid');
        }

        return parent::filter($query, $scopes);
    }

    public function getFormFields($object) {
        $fields = parent::getFormFields($object);
        $fields['booking'] = $object->booking ? $object->booking : null;
        $fields['invoice'] = $object ? $object : null;

        if($fields['invoice']['family_address'] && $fields['invoice']['family_address'] !== 'null') {
            $fields['invoice']['family_address_country'] = "'" . $fields['invoice']['family_address']['country'] . "'";
        } // workaround twill error #175

        if($fields['invoice']['babysitter_address'] && $fields['invoice']['babysitter_address'] !== 'null') {
            $fields['invoice']['babysitter_address_country'] = "'" . $fields['invoice']['babysitter_address']['country'] . "'";
        } // workaround twill error #175

        return $fields;
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        $fields = parent::prepareFieldsBeforeSave($object, $fields);

        if(array_key_exists('invoice.amountPaidInPounds', $fields))
        {
            $fields['amount_paid'] = $fields['invoice.amountPaidInPounds'] * 100;
            $fields['amount_due'] = $fields['invoice.amountDueInPounds'] * 100;
            unset($fields['invoice.amountPaidInPounds'], $fields['invoice.amountDueInPounds']);

            if((int) $fields['amount_paid'] !== (int) $object->amount_paid && (int) $fields['amount_paid'] === (int) $fields['amount_due'])
            {
                $fields['paid_at'] = (new \DateTime())->format('Y-m-d H:i:s');
            }
        }

        $fields['babysitter_address'] = [
            'address1' => $fields['invoice.babysitter_address.address1'] ?? '',
            'address2' => $fields['invoice.babysitter_address.address2'] ?? '',
            'town' => $fields['invoice.babysitter_address.town'] ?? '',
            'postcode' => $fields['invoice.babysitter_address.postcode'] ?? '',
            'country' => $fields['invoice.babysitter_address_country'] ?? '',
        ];

        $fields['family_address'] = [
            'address1' => $fields['invoice.family_address.address1'] ?? '',
            'address2' => $fields['invoice.family_address.address2'] ?? '',
            'town' => $fields['invoice.family_address.town'] ?? '',
            'postcode' => $fields['invoice.family_address.postcode'] ?? '',
            'country' => $fields['invoice.family_address_country'] ?? '',
        ];

        return $fields;
    }

    public function getCountForPaidInvoices()
    {
        return $this->model->whereColumn('amount_due', 'amount_paid')->count();
    }

    public function getCountForUnpaidInvoices()
    {
        return $this->model->whereColumn('amount_due', '<>', 'amount_paid')->count();
    }
}
