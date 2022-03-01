<?php

namespace App\Http\Controllers\Babysitter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Babysitter\storeNewBookingInvoiceRequest;
use App\Models\BabysitterPayout;
use App\Models\Booking;
use App\Models\BookingInvoice;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $user = User::with('babysitter.invoices')->findOrFail($this->user_id);
        $payouts = BabysitterPayout::whereIn('invoice_id', $user->babysitter->invoices->pluck('id') ?? [])->get();
        $payouts_transferred_total = number_format($payouts->sum('amount') / 100,2);
        $completed_payouts = $payouts->filter(function ($p) {
            return $p->status === 'Withdrawal successful' || $p->status === 'Partially authorized';
        })->count();
        $pending_payouts = $payouts->where('status', 'Pending authorization')->count();

        return view('babysitter.transactions')->with([
            'user' => $user,
            'payouts' => $payouts,
            'payouts_transferred_total' => $payouts_transferred_total,
            'completed_payouts' => $completed_payouts,
            'pending_payouts' => $pending_payouts,
        ]);
    }
}
