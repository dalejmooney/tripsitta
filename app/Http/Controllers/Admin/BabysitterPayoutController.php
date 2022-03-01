<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\BabysitterPayout;
use App\Service\PayoutsService;

class BabysitterPayoutController extends ModuleController
{
    protected $moduleName = 'babysitterPayouts';

    protected $titleColumnKey = 'id';
    protected $titleFormKey = 'id';
    protected $indexWith = ['invoice.babysitter'];
    protected $formWith = ['bank_details'];

    protected $indexColumns = [
        'id' => [
            'title' => 'Payout ID',
            'field' => 'id',
            'sort' => true,
        ],
        'babysitter' => [
            'title' => 'Babysitter',
            'relationship' => 'invoice.babysitter.user',
            'field' => 'fullNameWithLink',
        ],
        'invoice_id' => [
            'title' => 'Invoice',
            'field' => 'invoiceIdWithLink',
            'sort' => true,
        ],
        'invoice_paid_by_customer' => [
            'title' => 'Customer invoice paid',
            'field' => 'balanceStatus',
            'relationship' => 'invoice',
            'sort' => true,
        ],
        'amount_paid' => [
            'title' => 'Babysitter received',
            'field' => 'amountFormattedColoured',
            'sort' => true,
        ],
        'invoice_babysitter_earn' => [
            'title' => 'Total for babysitter',
            'field' => 'babysitterEarningFormatted',
            'relationship' => 'invoice',
        ],
    ];

    protected $indexOptions = [
        'create' => false,
        'publish' => false,
        'restore' => false,
        'permalink' => false,
        'delete' => false,
        'bulkEdit' => false,
        'bulkDelete' => false,
    ];

    public function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = parent::getIndexTableMainFilters($items, $scopes);

        array_push($statusFilters, [
            'name' => 'Unpaid',
            'slug' => 'pending',
            'number' => $this->repository->getCountForUnpaid(),
        ],[
            'name' => 'Paid/Partially paid',
            'slug' => 'paid',
            'number' => $this->repository->getCountForPaid(),
        ]);


        return $statusFilters;
    }

    public function getTransferwiseProfiles()
    {
        $transferwise = new PayoutsService(0);
		//dd($transferwise->getProfiles());		
        return view('admin.transferwise_profiles')->with([
            'profiles' => json_decode($transferwise->getProfiles(), true)
        ]);
    }

    public function processPayout(BabysitterPayout $payout)
    {
        $payout->load('bank_details');

        $transferwise = new PayoutsService();

        // check if payment needs to be made at all (if marked as paid already)
        if($payout->amount > 0 || $payout->transferwise_payment_id)
        {
            return response()->json(['status' => 'error', 'message' => 'Payment is already recorded for this invoice. To reset make sure to zero the paid amount and remove transferwise transfer id', 'details' => [] ]);
        }

        // check if recipient already added to transferwise
        if($payout->bank_details->transferwise_account_id)
        {
            $recipient_id = (int) $payout->bank_details->transferwise_account_id;
        }
        else
        {
            if($payout->bank_details->currency === 'gbp')
            {
                $extra_fields = [
                    'legalType' => 'PRIVATE',
                    'sortCode' => $payout->bank_details->sort_code,
                    'accountNumber' => $payout->bank_details->account_number,
                ];
            }
            elseif($payout->bank_details->currency === 'chf')
            {
                $extra_fields = [
                    'legalType' => 'PRIVATE',
                    'iban' => $payout->bank_details->iban,
                    'town' => $payout->bank_details->town,
                ];
            }
            elseif($payout->bank_details->currency === 'usd')
            {
                $extra_fields = [
                    'legalType' => 'PRIVATE',
                    'abartn' => $payout->bank_details->sort_code,
                    'accountNumber' => $payout->bank_details->account_number,
                    'accountType' => $payout->bank_details->account_type,
                    'address' => [
                        'country' => 'us',
                        'state' => $payout->bank_details->state,
                        'city' => $payout->bank_details->town,
                        'postCode' => $payout->bank_details->postcode,
                        'firstLine' => $payout->bank_details->address1,
                        'occupation' => 'babysitter'
                    ]
                ];
            }
            else{
                $extra_fields = [
                    'legalType' => 'PRIVATE',
                    'iban' => $payout->bank_details->iban,
                ];
            }

            // create new one if needed
            $new_recipient = $transferwise->postCreateAccount(
                $payout->bank_details->name,
                $payout->bank_details->currency,
                $payout->bank_details->transferwise_type,
                $extra_fields
            );
            $new_recipient = json_decode($new_recipient, true);

            if(array_key_exists('errors', $new_recipient))
            {
                $messages = [];
                foreach($new_recipient['errors'] as $error){
                    $messages[] = $error['message'];
                }
                return redirect()->back()->withErrors(['status' => 'TransferWise returned error when creating recipient account. Make sure all details are provided and correct !'])
                    ->with(['error_details' => $messages]);
            }

            // save new recipient id to DB
            $payout->bank_details->transferwise_account_id = $new_recipient['id'];
            $payout->push();
            $payout->refresh();

            $recipient_id = (int) $new_recipient['id'];
        }

        if(!$recipient_id || $recipient_id <= 0)
        {
            return redirect()->back()->withErrors(['status' => 'Recipient not assigned for payout. Action cancelled!']);
        }

        // if all ok, create a transfer quote
        $quote = $transferwise->postCreateQuote(
            'BALANCE_PAYOUT',
            'EUR',
            $payout->bank_details->currency,
            $payout->invoice->babysitter_earnings_in_pounds,
            null
        );

        $quote = json_decode($quote, true);

        if(array_key_exists('errors', $quote))
        {
            return redirect()->back()->withErrors(['status' => 'TransferWise returned error when creating a transfer quote. Action cancelled!']);
        }

        // if all ok, create a transfer order
        $transfer = $transferwise->postCreateTransfer(
            $recipient_id,
            $quote['id'],
            $payout->invoice->reference
        );

        $transfer = json_decode($transfer, true);

        if(array_key_exists('errors', $transfer))
        {
            return redirect()->back()->withErrors(['status' => 'TransferWise returned error when processing the transfer. Action cancelled!']);
        }

        // if all ok, fund the transfer
        $fund_transfer = $transferwise->postFundTransfer(
            $transfer['id']
        );

        $fund_transfer = json_decode($fund_transfer, true);

        if(array_key_exists('errors', $transfer))
        {
            return redirect()->back()->withErrors(['status' => 'TransferWise returned error when funding the transfer. Action cancelled!']);
        }

        // mark payout as completed
        $payout->amount = $payout->invoice->babysitter_earnings;
        $payout->transferwise_payment_id = $transfer['id']; // transfer id and not balance transfer id
        $payout->save();

        return redirect()->back()->with(['status' => 'TransferWise completed the payment successfully']);
    }
}
