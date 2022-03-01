<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Babysitter\storeNewBookingInvoiceRequest;
use App\Http\Requests\Parent\PayBookingInvoiceRequest;
use App\Models\Booking;
use App\Models\BookingInvoice;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class BookingInvoicesController extends Controller
{
    public function index(Booking $booking = null, $stripe_checkout_session_id = null)
    {
        $user = User::with('family.invoices.booking.babysitter.user')->findOrFail($this->user_id);

        return view('parent.invoices')->with([
            'user' => $user,
            'invoices' => $user->family->invoices->sortByDesc('created_at'),
            'filter_booking_id' => ($booking) ? $booking->id : '',
            'stripe_checkout_session_id' => $stripe_checkout_session_id,
        ]);
    }

    public function show(BookingInvoice $invoice)
    {
        try{
            $invoice->load(['booking', 'babysitter.user', 'family.user']);

            $invoice_tpl = view('invoice.template-parent', ['invoice' => $invoice])->render();
        } catch (\Throwable $e) {
            abort(404);
            return NULL;
        }

        return PDF::loadHtml($invoice_tpl)->stream('download.pdf');
    }

    public function selectToPay($invoice)
    {
        $invoice->load('booking');

        try{
            Stripe::setApiKey(config('tripsitta.stripe.secret'));
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'name' => 'Payment for invoice '.$invoice->reference,
                    'description' => (empty($invoice->description)) ? 'Invoice '.$invoice->reference.' for booking '.$invoice->booking->idPadded : $invoice->description,
                    'amount' => $invoice->amount_due,
                    'currency' => 'eur',
                    'quantity' => 1,
                ]],
                "metadata" => [
                    "booking_id" => $invoice->booking_id,
                    "invoice_id" => $invoice->id,
                ],
                'success_url' => route('parent.invoices', [$invoice->booking_id]).'/{CHECKOUT_SESSION_ID}',
                'cancel_url' => route('parent.invoices', [$invoice->booking_id]),
            ]);
            $session_id = $session->id;
        } catch ( ApiErrorException $e)
        {
            $session_id = null;
        }

        return response()->json(['session' => $session_id]);
    }
}
