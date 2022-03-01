<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\BookingInvoice;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Log;

class InvoiceController extends ModuleController
{
    protected $moduleName = 'invoices';
    protected $modelName = 'BookingInvoice';
    protected $titleColumnKey = 'reference';
    protected $titleFormKey = 'reference';
    protected $indexWith = ['booking'];

    protected $indexOptions = [
        'publish' => false,
        'restore' => false,
        'permalink' => false,
    ];

    protected $indexColumns = [
        'reference' => [
            'title' => 'Reference',
            'field' => 'reference',
            'sort' => true,
        ],
        'booking_id' => [
            'title' => 'Booking ID',
            'relationship' => 'booking',
            'field' => 'idPadded',
            'sort' => true,
        ],
        'due' => [
            'title' => 'Amount due',
            'field' => 'amountDueFormatted',
            'sort' => true,
        ],
        'paid' => [
            'title' => 'Amount paid',
            'field' => 'amountPaidFormatted',
            'sort' => true,
        ],
        'balance' => [
            'title' => 'Balance',
            'field' => 'balanceFormatted',
            'sort' => true,
        ],
        'created' => [
            'title' => 'Created',
            'field' => 'createdDate',
            'sort' => true,
        ],
        'earnings_p' => [
            'title' => 'Earnings predicted',
            'field' => 'adminEarningFormatted',
            'sort' => true,
        ],
        'earnings' => [
            'title' => 'Earnings current',
            'field' => 'adminEarningCurrentFormatted',
            'sort' => true,
        ],
    ];

    public function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = parent::getIndexTableMainFilters($items, $scopes);

        array_push($statusFilters,
            [
                'name' => 'Paid',
                'slug' => 'paid',
                'number' => $this->repository->getCountForPaidInvoices(),
            ],
            [
                'name' => 'Unpaid',
                'slug' => 'unpaid',
                'number' => $this->repository->getCountForUnpaidInvoices(),
            ]
        );

        return $statusFilters;
    }

    public function showInvoice(BookingInvoice $invoice, string $version='parent') : ?\Illuminate\Http\Response
    {
        try {
            if(!in_array($version, ['parent', 'admin', 'babysitter']))
            {
                throw new \Exception('Incorrect invoice version requested');
            }

            $invoice->load(['booking', 'babysitter.user', 'family.user']);

            $invoice_tpl = view('invoice.template-' . $version, ['invoice' => $invoice])->render();
        } catch (\Throwable $e) {
            Log::error($e->getMessage(), ['trace' =>$e->getTraceAsString()]);
            abort(404);
            return NULL;
        }

        return PDF::loadHtml($invoice_tpl)->stream('download.pdf');
    }
}
