<?php

namespace App\Http\Controllers\Babysitter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Mail\BabysitterBookingStatusConfirmedForBabysitter;
use App\Mail\BabysitterBookingStatusConfirmedForParent;
use App\Mail\BookingCancelledByBabysitter;
use App\Mail\BookingCompletedForParent;
use App\Mail\HolidayNannyBookingCancelledByBabysitter;
use App\Mail\HolidayNannyBookingStatusConfirmedForBabysitter;
use App\Models\Booking;
use App\Models\BookingStatus;

class BookingStatusController extends Controller
{
    public function update(UpdateBookingStatusRequest $request, Booking $booking)
    {
        if((int) $request->input('new_status_int') === 0)
        {
            $booking->confirmStatus();
            return response()->json(['success' => 'Booking status confirmed']);
        }
        $new_status = BookingStatus::findOrFail($request->input('new_status_int'));

        $booking->setStatus($request->input('new_status_int'));

        if($request->input('new_status_int') === 2) // cancelled by babysitter
        {
            if($booking->type === 'babysitter')
            {
                \Mail::to($booking->family->user->email)->send(new BookingCancelledByBabysitter(
                    $booking->family->user->name,
                    $booking->babysitter->user->name
                ));
            }
            else
            {
                \Mail::to($booking->family->user->email)->send(new HolidayNannyBookingCancelledByBabysitter(
                    $booking->family->user->name,
                    $booking->babysitter->user->name
                ));
            }
        }
        if($request->input('new_status_int') === 4) // confirmed
        {
            if($booking->type === 'babysitter')
            {
                \Mail::to($booking->family->user->email)->send(new BabysitterBookingStatusConfirmedForParent(
                    $booking->family->user->name,
                    $booking->babysitter->user->name
                ));

                \Mail::to($booking->babysitter->user->email)->send(new BabysitterBookingStatusConfirmedForBabysitter(
                    $booking->babysitter->user->name,
                    $booking->startDate,
                    $booking->endDate,
                    implode(',', array_filter($booking->bookingAddress->only(['building', 'address1', 'address2', 'town', 'postcode'])))
                ));
            }
            else{
                \Mail::to($booking->family->user->email)->send(new BabysitterBookingStatusConfirmedForParent( // same as above for now
                    $booking->family->user->name,
                    $booking->babysitter->user->name
                ));

                \Mail::to($booking->babysitter->user->email)->send(new HolidayNannyBookingStatusConfirmedForBabysitter(
                    $booking->babysitter->user->name,
                    $booking->startDate,
                    $booking->endDate,
                ));
            }
        }
        if($request->input('new_status_int') === 5) // completed
        {
            \Mail::to($booking->family->user->email)->send(new BookingCompletedForParent(
                $booking->family->user->name,
                $booking->babysitter->user->name
            ));
        }

        return response()->json(['success' => 'Booking status changed to "'.$new_status->name.'". Customer will automatically receive email with status update', 'new_status' => $new_status->name]);
    }
}
