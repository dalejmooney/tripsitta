<?php

namespace App\Http\Controllers\Parent;

use App\Models\Booking;
use App\Models\BookingInvoice;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OverviewController extends Controller
{
    public function index(){
        $user = User::with(['family'])->findOrFail($this->user_id);
        if(is_null($user->family)){
            Auth::logout();
            return redirect()->route('login')->with('error-msg', 'This account has been deleted. Please contact us if it\'s an error or if you would like to re-enable your account');
        }

        $bookings_need_action = Booking::forFamily($user->id)->whereNotNull('babysitter_completed_at')->whereNull('parent_completed_at')->count();
        $invoices_need_payment = BookingInvoice::whereHas('booking', function ($query) {
            return $query->where('family_id', $this->user_id);
        })->whereRaw('amount_paid < amount_due')->count();

        $upcoming_booking = Booking::forFamily($user->id)->upcomingBookings()->confirmedOnly()->orderByDesc('start')->first();

        return view('parent.overview')->with([
            'user' => $user,
            'bookings_need_action' => $bookings_need_action,
            'invoices_need_payment' => $invoices_need_payment,
            'upcoming_booking' => $upcoming_booking,
        ]);
    }
}
