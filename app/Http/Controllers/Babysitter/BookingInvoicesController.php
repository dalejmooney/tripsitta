<?php

namespace App\Http\Controllers\Babysitter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Babysitter\storeNewBookingInvoiceRequest;
use App\Mail\BookingNewInvoiceRaised;
use App\Models\Booking;
use App\Models\BookingInvoice;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class BookingInvoicesController extends Controller
{
    public function index(Booking $booking = null)
    {
        $user = User::with('babysitter.invoices.booking.family.user')->findOrFail($this->user_id);

        $earned_this_month = $user->babysitter->invoices
            ->where('created_at', '>=', (new \Carbon\Carbon())->startOfMonth())
            ->where('created_at', '<=', (new \Carbon\Carbon())->endOfMonth())
            ->where('balance', '=', 0)
        ->sum('babysitterEarningsInPounds');

        $earned_total = $user->babysitter->invoices->where('balance', '=', 0)->sum('babysitterEarningsInPounds');

        return view('babysitter.invoices')->with([
            'user' => $user,
            'invoices' => $user->babysitter->invoices->sortByDesc('created_at'),
            'filter_booking_id' => ($booking) ? $booking->id : '',
            'earned_this_month' => $earned_this_month,
            'earned_total' => $earned_total,
        ]);
    }

    public function show(BookingInvoice $invoice)
    {
        try{
            $invoice->load(['booking', 'babysitter.user', 'family.user']);

            $invoice_tpl = view('invoice.template-babysitter', ['invoice' => $invoice])->render();
        } catch (\Throwable $e) {
            abort(404);
            return NULL;
        }

        return PDF::loadHtml($invoice_tpl)->stream('download.pdf');
    }

    public function create(Booking $booking)
    {
        $user = User::with('babysitter')->findOrFail($this->user_id);

        return view('babysitter.invoice-create')->with([
            'user' => $user,
            'booking' => $booking,
        ]);
    }

    public function store(storeNewBookingInvoiceRequest $request, Booking $booking)
    {
        $amount_in_cents = $request->input('amount_due') * 100;
        $new_invoice = $booking->createInvoice($request->input('type'), $amount_in_cents, 0, null, $request->input('description'));

        //event(new NewInvoiceCreated($new_invoice));
        // email parent about new invoice
        \Mail::to($booking->family->user->email)->send(new BookingNewInvoiceRaised(
            $booking->family->user->name,
            $booking->babysitter->user->name
        ));

        return redirect()->back()->with(['status' => ['type' => 'success', 'message' => 'New invoice ref: "'.$new_invoice->reference.'" created successfully']]);
    }
}
