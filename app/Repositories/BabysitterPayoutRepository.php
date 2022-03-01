<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\BabysitterPayout;

class BabysitterPayoutRepository extends ModuleRepository
{


    public function __construct(BabysitterPayout $model)
    {
        $this->model = $model;
    }

    public function order($query, array $orders = []) {
        if (array_key_exists('invoice.babysitter.userFullNameWithLink', $orders)){
            $sort_method = $orders['invoice.babysitter.userFullNameWithLink'];
            unset($orders['invoice.babysitter.userFullNameWithLink']);
            $query = $this->orderUser($query, 'name', $sort_method);
        }

        if (array_key_exists('invoiceIdWithLink', $orders)){
            $sort_method = $orders['invoiceIdWithLink'];
            unset($orders['invoiceIdWithLink']);
            $query = $query->orderBy('invoice_id', $sort_method);
        }

        if (array_key_exists('invoiceBalanceStatus', $orders)){
            $sort_method = $orders['invoiceBalanceStatus'];
            unset($orders['invoiceBalanceStatus']);
            $query = $this->orderBalanceStatus($query, 'amount_paid', $sort_method);
        }

        if (array_key_exists('amountFormattedColoured', $orders)){
            $sort_method = $orders['amountFormattedColoured'];
            unset($orders['amountFormattedColoured']);
            $query = $query->orderBy('amount', $sort_method);
        }

        return parent::order($query, $orders);
    }

    private function orderBalanceStatus($query, $field_name, $sort_method)
    {
        return $query->leftJoin('booking_invoices', 'booking_invoices.id', '=', 'babysitter_payouts.invoice_id')->select('babysitter_payouts.*', 'booking_invoices.amount_paid', 'booking_invoices.amount_due')->orderBy($field_name, $sort_method);
    }

    public function filter($query, array $scopes = []) {
        $filter_status = '';
        $filter = (array_key_exists('filter', request()->input())) ? json_decode(request()->input()['filter'], true) : null;

        if(is_array($filter) && array_key_exists('status', $filter)){
            $filter_status = $filter['status'];
        }

        if($filter_status === 'pending')
        {
            $query->where('amount', 0);
        }
        if($filter_status === 'paid')
        {
            $query->where('amount', '>',0);
        }

        //search by booking id
        if (isset($scopes['%id'])) {
            $query
                ->select('babysitter_payouts.*', 'booking_invoices.id as bi_id', 'booking_invoices.booking_id as bi_bi', 'bookings.id as bid')
                ->leftJoin('booking_invoices', 'booking_invoices.id', 'babysitter_payouts.invoice_id')
                ->leftJoin('bookings', 'bookings.id', 'booking_invoices.booking_id')
                ->where(function($q) use($scopes){
                    $q->where('bookings.id', 'like', '%'.$scopes['%id'].'%');
                })
            ;

            unset($scopes['%id']);
        }

        return parent::filter($query, $scopes);
    }


    public function getFormFields($object) {
        $fields = parent::getFormFields($object);

        $bank_details = $object->bank_details()->withTrashed()->first();
        $object->bank_details = $bank_details;

        $fields['invo_reference'] = $object->invoice->reference;
        $fields['bank_details'] = $object->bank_details;

        $fields['amount_pounds'] = number_format($object->amountInPounds, 2,'.', '');
        $fields['total_to_pay'] = number_format($object->invoice->babysitterEarningsInPounds, 2,'.', '');

        return $fields;
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        $new_fields = [
            'amount' => $fields['amount_pounds'] * 100,
            'transferwise_payment_id' => $fields['transferwise_payment_id'] == '' ? null : $fields['transferwise_payment_id'],
        ];

        return $new_fields;
    }

    public function getCountForUnpaid()
    {
        return $this->model->where('amount', 0)->count();
    }

    public function getCountForPaid()
    {
        return $this->model->where('amount', '>', 0)->count();
    }
}
