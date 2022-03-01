<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Mail\BookingCancelledByParent;
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

        if($request->input('new_status_int') === 3) // cancelled by parent
        {
            if($booking->type === 'babysitter')
            {
                \Mail::to($booking->family->user->email)->send(new BookingCancelledByParent(
                    $booking->babysitter->user->name,
                    $booking->startDate,
                    $booking->endDate,
                ));
            }
            else
            {
                \Mail::to($booking->family->user->email)->send(new HolidayNannyBookingCancelledByParent(
                    $booking->babysitter->user->name,
                    $booking->startDate,
                    $booking->endDate,
                ));
            }
        }

        return response()->json(['success' => 'Booking status changed to "'.$new_status->name.'". Babysitter will automatically receive email with status update', 'new_status' => $new_status->name]);
    }
}
