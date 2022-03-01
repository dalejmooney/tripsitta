<?php

namespace App\Http\Controllers\Babysitter;

use App\Models\Booking;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OverviewController extends Controller
{
    public function index(){
        $user = User::with('babysitter')->findOrFail($this->user_id);
        if(is_null($user->babysitter)){
            Auth::logout();
            return redirect()->route('login')->with('error-msg', 'This account has been deleted. Please contact us if it\'s an error or if you would like to re-enable your account');
        }

        $bookings_need_action = Booking::bookingNeedBabysitterAction($this->user_id)->count();
        $upcoming_booking = Booking::upcomingBookings()->forBabysitter($user->babysitter)->confirmedOnly()->with(['family', 'bookingStatus'])->orderBy('start')->first();

        $booking_total_count = Booking::forBabysitter($this->user_id)->confirmedOrCompletedOnly()->count();
        $booking_future_count = Booking::forBabysitter($this->user_id)->confirmedOrCompletedOnly()->upcomingBookings()->count();
        $booking_past_count = Booking::forBabysitter($this->user_id)->pastBookings()->confirmedOrCompletedOnly()->count();

        return view('babysitter.overview')->with([
            'user' => $user,
            'bookings_need_action' => $bookings_need_action,
            'upcoming_booking' => $upcoming_booking,
            'booking_total_count' => $booking_total_count,
            'booking_future_count' => $booking_future_count,
            'booking_past_count' => $booking_past_count,
        ]);
    }
}
