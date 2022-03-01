<?php

namespace App\Traits;

use App\Models\Babysitter;
use App\Models\BabysitterAvailability;
use App\Models\BabysitterBookedAvailability;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

trait BookingChecks{

    use BabysitterAvailabilitySearch;

    public function validDates(string $booking_type, Carbon $date_start, Carbon $date_end)
    {
        if($date_start->greaterThan($date_end))
        {
            return false;
        }

        if($booking_type === 'babysitter')
        {
            if(!$this->validBookingWindow($date_start))
            {
                return false;
            }

            if($date_start->diffInHours($date_end) < 2) // min 2 hours booking
            {
                return false;
            }

            if($date_start->diffInHours($date_end) > 48) // max 2 days booking
            {
                return false;
            }
        }
        else
        {
            if($date_start->diffInDays($date_end) < 1) // min 1 day booking
            {
                return false;
            }
        }

        return true;
    }

    public function getDaysToCheck(string $booking_type, Carbon $start_date, Carbon $end_date)
    {
        $booking_period = CarbonPeriod::create($start_date, $end_date);
        $period_days = [];

        if($booking_type === 'babysitter')
        {
            // get availability (array of days and period of times)
            $availability_required = $this->searchAvailability($start_date, $end_date);

            // also make sure we check for holiday nanny bookings to avoid double booking
            foreach ($booking_period as $key => $date) {
                $period_days[$date->format('Y-m-d')][] = 'holiday_nanny';
            }

            $period_days = array_merge_recursive($availability_required, $period_days);
        }
        else
        {
            foreach ($booking_period as $key => $date) {
                $period_days[$date->format('Y-m-d')] = ['holiday_nanny', 'babysitter-day', 'babysitter-night'];
            }
        }

        return $period_days;
    }

    public function getAvailableHolidayNannies(Carbon $start_date, Carbon $end_date)
    {
        $period_days = $this->getDaysToCheck('holiday_nanny', $start_date, $end_date);
        $booked_babysitters = BabysitterBookedAvailability::listBooked($period_days)->groupBy('babysitter_id')->get(['babysitter_id'])->pluck('babysitter_id');

        $available = DB::table('babysitter_availabilities')
            ->select(DB::raw('count(babysitter_id) as no_of_days'), 'babysitter_id')
            ->where('type', 'holiday_nanny')
            ->where('date', '>=', $start_date->format('Y-m-d'))
            ->where('date', '<=', $end_date->format('Y-m-d'))
            ->whereNotIn('babysitter_id', $booked_babysitters->toArray())
            ->groupBy('babysitter_id')
            ->having(DB::raw('count(babysitter_id)'), '>=', DB::raw("abs(datediff(?, ?))"))
            ->setBindings([$start_date->format('Y-m-d'), $end_date->format('Y-m-d')], 'having')
            ->get();

        $available = $available->map(function ($item) {
            return $item->babysitter_id;
        });

        $nannies = Babysitter::with(['user'])->active()->acceptsNannyJobs()->whereIn('id', $available->toArray())->get();

        return $nannies;
    }

    public function getAvailableBabysitters(Carbon $start_date, Carbon $end_date, $search_address)
    {
        // get availability (array of days and period of times)
        $availability_required = $this->searchAvailability($start_date, $end_date);
        // find ids of babysitters with availability for selected time period
        $available_babysitters = BabysitterAvailability::listAvailable($availability_required)->groupBy('babysitter_id')->get(['babysitter_id'])->pluck('babysitter_id');
        // find id of already booked babysitters
        $period_days = $this->getDaysToCheck('babysitter', $start_date, $end_date);
        $booked_babysitters = BabysitterBookedAvailability::listBooked($period_days)->groupBy('babysitter_id')->get(['babysitter_id'])->pluck('babysitter_id');

        // find babysitters that live in the town/country combo and are available
        $babysitters = Babysitter::with(['user', 'reviewsAverage', 'reviews', 'languages'])
            ->whereHas('addresses', function($q) use($search_address){
                $q->where('babysitter_addresses.country', '=', $search_address[0])->where('babysitter_addresses.town', '=', $search_address[1]);
            })
            ->active()->acceptsBabysitterJobs()->whereIn('id', $available_babysitters->toArray())->whereNotIn('id', $booked_babysitters->toArray())->get();

        return $babysitters;
    }

    public function isSelectedBabysitterAvailable(int $babysitter_id, Carbon $start_date, Carbon $end_date, array $search_address) :bool
    {
        $babysitters = $this->getAvailableBabysitters($start_date, $end_date, [$search_address['country_code'], $search_address['town']]);

        if(!$babysitters) return false;

        return $babysitters->contains('id', $babysitter_id);
    }

    public function isSelectedHolidayNannyAvailable(int $babysitter_id, Carbon $start_date, Carbon $end_date) :bool
    {
        $babysitters = $this->getAvailableHolidayNannies($start_date, $end_date);

        if(!$babysitters) return false;

        return $babysitters->contains('id', $babysitter_id);
    }

    private function validBookingWindow(Carbon $date_start)
    {
        return $date_start > (new Carbon())->addMinutes(90);
    }
}
