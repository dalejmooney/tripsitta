<?php

namespace App\Http\Controllers\Babysitter;

use App\Http\Requests\Babysitter\UpdateBookingStatusRequest;
use App\Models\Babysitter;
use App\Models\Booking;
use App\Models\BookingInvoice;
use App\Models\BookingStatus;
use App\Service\BookingCommission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index(){
        $user = User::with('babysitter')->findOrFail($this->user_id);

        $current_booking = Booking::currentBookings()->forBabysitter($user->babysitter)->with(['family', 'bookingStatus'])->get();
        $upcoming_bookings = Booking::upcomingBookings()->forBabysitter($user->babysitter)->with(['family', 'bookingStatus'])->orderBy('start')->get();
        $past_bookings = Booking::pastBookings()->forBabysitter($user->babysitter)->with(['family', 'bookingStatus'])->orderByDesc('start')->get();

        return view('babysitter.bookings')->with([
            'user' => $user,
            'current_booking' => $current_booking,
            'upcoming_bookings' => $upcoming_bookings,
            'past_bookings' => $past_bookings,
        ]);
    }

    public function show(Booking $booking)
    {
        $user = User::with('babysitter.mainAddress')->findOrFail($this->user_id);
        $booking->load(['family', 'bookingChildren', 'bookingStatus', 'bookingAddress', 'invoices']);
        $status_options = $booking->getPossibleBookingStatuses();
        $booking_total = BookingInvoice::getGrandTotalForBooking($booking,true);
        $booking_paid = BookingInvoice::getPaidAmountForBooking($booking,true);
        $booking_to_pay = $booking_paid - $booking_total;
        $earnings = (new BookingCommission())->estimate($booking->type, $booking_paid * 100)['for_babysitter'] / 100;
        $earnings_full = (new BookingCommission())->calculateForBooking($booking)['for_babysitter'] / 100;

        return view('babysitter.booking')->with([
            'user' => $user,
            'booking' => $booking,
            'status_options' => $status_options,
            'booking_amounts' => collect([
                'total' => $booking_total,
                'paid' => $booking_paid,
                'to_pay' => $booking_to_pay,
                'babysitter_earnings' => $earnings,
                'babysitter_earnings_full' => $earnings_full,
            ]),
        ]);
    }
}
