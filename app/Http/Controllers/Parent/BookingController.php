<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingInvoice;
use App\Service\BookingCommission;
use App\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(){
        $user = User::with('family')->findOrFail($this->user_id);

        $bookings = Booking::forFamily($user->family)->with(['babysitter', 'bookingStatus', 'invoices'])->orderByDesc('start')->get();

        return view('parent.bookings')->with([
            'user' => $user,
            'bookings' => $bookings,
        ]);
    }

    public function show(Booking $booking)
    {
        $user = User::with('family')->findOrFail($this->user_id);
        $booking->load(['babysitter.mainAddress', 'bookingChildren', 'bookingStatus', 'bookingAddress', 'invoices']);
        $status_options = $booking->getPossibleBookingStatuses();
        $booking_total = BookingInvoice::getGrandTotalForBooking($booking,true);
        $booking_paid = BookingInvoice::getPaidAmountForBooking($booking,true);
        $booking_to_pay = $booking_paid - $booking_total;

        return view('parent.booking')->with([
            'user' => $user,
            'booking' => $booking,
            'status_options' => $status_options,
            'booking_amounts' => collect([
                'total' => $booking_total,
                'paid' => $booking_paid,
                'to_pay' => $booking_to_pay,
            ]),
        ]);
    }
}
