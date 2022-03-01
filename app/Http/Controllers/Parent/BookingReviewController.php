<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parent\StoreBookingReviewRequest;
use App\Models\BabysitterReview;
use App\Models\Booking;
use App\User;

class BookingReviewController extends Controller
{
    public function show(Booking $booking)
    {
        $user = User::with('family')->findOrFail($this->user_id);

        return view('parent.booking-review')->with([
            'user' => $user,
            'booking' => $booking,
        ]);
    }

    public function store(Booking $booking, StoreBookingReviewRequest $request)
    {
        $review = new BabysitterReview();
        $review->babysitter_id = $booking->babysitter_id;
        $review->booking_id = $booking->id;
        $review->title = $request->input('title');
        $review->description = $request->input('message');
        $review->score = $request->input('rating');
        $review->published = 0;

        if(!$review->save())
        {
            return response()->json(['error' => 'Error occurred when saving your review. Please try again'], 500);
        }

        return response()->json(['success' => 'Thank you for taking time to review your babysitter!']);
    }
}
