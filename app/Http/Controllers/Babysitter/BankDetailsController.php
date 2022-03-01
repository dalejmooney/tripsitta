<?php

namespace App\Http\Controllers\Babysitter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Babysitter\storeBankDetails;
use App\Models\BabysitterBankDetail;
use App\User;

class BankDetailsController extends Controller
{
    public function index()
    {
        $user = User::with('babysitter.bank')->findOrFail($this->user_id);

        return view('babysitter.bank_details')->with([
            'user' => $user,
            'transferwise_payout_currencies' => config('tripsitta.transferwise_payout_currencies'),
        ]);
    }

    public function store(storeBankDetails $request)
    {
        $user = User::with('babysitter.bank')->findOrFail($this->user_id);

        $data = $request->validated();
        $data['transferwise_type'] = BabysitterBankDetail::getTransferwiseTypeFromCurrency($request->get('currency'));

        $user->babysitter->bank()->delete();
        $user->babysitter->bank()->create($data);

        return redirect()->back()->with(['status' => ['type' => 'success', 'message' => 'Bank details updated']]);
    }
}
