<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingInvoice;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function action(Request $request)
    {
        Stripe::setApiKey(config('tripsitta.stripe.secret'));

        $endpoint_secret = config('tripsitta.stripe.webhook_secret');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response(null, 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response(null, 400);
        }

        // Handle the checkout.session.completed event
        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;

            if($session->metadata->new_booking && $session->metadata->original_booking_session)
            {
                $booking = Booking::where('original_booking_session', $session->metadata->original_booking_session)->firstOrFail();
                $invoice = BookingInvoice::where('booking_id', $booking->id)->firstOrFail();

                if($invoice->amount_paid >= $invoice->amount_due) return response(null, 400);
            }
            else
            {
                if(!$session->metadata->booking_id || !$session->metadata->invoice_id) return response(null, 400);

                $invoice = BookingInvoice::where('booking_id', $session->metadata->booking_id)->where('id', $session->metadata->invoice_id)->firstOrFail();

                if($invoice->amount_paid >= $invoice->amount_due) return response(null, 400);
            }

            $invoice->amount_paid = $invoice->amount_due;
            $invoice->paid_at = new \DateTime();
            $invoice->save();

            return response(null, 200);
        }

        return response(null, 400);
    }
}
