<?php

namespace App\Events;

use App\Models\Booking;
use App\Traits\BabysitterAvailabilitySearch;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmed
{
    use Dispatchable, InteractsWithSockets, SerializesModels,BabysitterAvailabilitySearch;

    public $booking;
    public $booking_days;

    /**
     * Create a new event instance.
     *
     * @param $booking
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->booking_days = $this->searchAvailability($booking->start, $booking->end);
    }
}
