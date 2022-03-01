<?php

namespace App\Listeners;

use App\Events\BookingConfirmed;
use App\Models\Babysitter;

class RemoveBabysitterAvailability
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookingConfirmed  $event
     * @return void
     */
    public function handle(BookingConfirmed $event)
    {
        $babysitter = Babysitter::with(['bookedAvailability'])->findOrFail($event->booking->babysitter_id);

        foreach($event->booking_days as $date => $type)
        {
            foreach($type as $i => $t) {
                $babysitter->bookedAvailability()->updateOrInsert(
                    [
                        'date' => $date,
                        'type' => $t,
                        'babysitter_id' => $event->booking->babysitter_id,
                    ],
                    [
                        'date' => $date,
                        'type' => $t,
                        'babysitter_id' => $event->booking->babysitter_id,
                    ]
                );
            }
        }
    }
}
