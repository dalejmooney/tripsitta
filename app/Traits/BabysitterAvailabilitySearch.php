<?php

namespace App\Traits;

use Carbon\CarbonPeriod;
use Carbon\Carbon;

trait BabysitterAvailabilitySearch{
    private $period;
    private $period_exact;

    /**
     * Returns array of dates and time of day. It's used when checking availability.
     * e.g. [ "2020-01-11" => [ 0 => "babysitter-day", 1 => "babysitter-night" ] ]
     *
     * @param Carbon $date_start
     * @param Carbon $date_end
     * @return array
     */
    public function searchAvailability(Carbon $date_start, Carbon $date_end)
    {
        $this->getPeriod($date_start, $date_end);
        $day_night_cutoff = config('tripsitta.babysitter_day_night_cutoff');

        $availability_required = [];

        // one day bookings
        if($this->period_exact->count() == 1){
            if($date_start <= (clone($date_start))->setTime($day_night_cutoff,0)){
                $availability_required[(clone($date_start))->format('Y-m-d')][] = 'babysitter-day';
                if($date_end > (clone($date_end))->setTime($day_night_cutoff,0)){
                    $availability_required[(clone($date_end))->format('Y-m-d')][] = 'babysitter-night';
                }
            }
            else
            {
                $availability_required[(clone($date_start))->format('Y-m-d')][] = 'babysitter-night';
            }
        }
        // 2 days
        elseif($this->period_exact->count() >= 2){
            if($date_start <= (clone($date_start))->setTime($day_night_cutoff,0)){
                $availability_required[(clone($date_start))->format('Y-m-d')][] = 'babysitter-day';
                $availability_required[(clone($date_start))->format('Y-m-d')][] = 'babysitter-night';
            }
            else
            {
                $availability_required[(clone($date_start))->format('Y-m-d')][] = 'babysitter-night';
            }

            if($date_end <= (clone($date_end))->setTime($day_night_cutoff,0)){
                $availability_required[(clone($date_end))->format('Y-m-d')][] = 'babysitter-day';
            }
            else
            {
                $availability_required[(clone($date_end))->format('Y-m-d')][] = 'babysitter-day';
                $availability_required[(clone($date_end))->format('Y-m-d')][] = 'babysitter-night';
            }
        }

        // additional days
        if($this->period->count() > 0)
        {
            foreach($this->period->toArray() as $day)
            {
                $availability_required[$day->format('Y-m-d')][] = 'babysitter-day';
                $availability_required[$day->format('Y-m-d')][] = 'babysitter-night';
            }
        }

        return $availability_required;
    }

    private function getPeriod($date_start, $date_end)
    {
        // get all dates within start and end date (needed for availability check).
        $sd = (clone($date_start))->setTime(0,0);
        $ed = (clone($date_end))->setTime(0, 0);
        $period = new CarbonPeriod($sd, $ed);

        $this->period_exact = new CarbonPeriod($sd, $ed); // includes start and end date

        $period->toggleOptions(CarbonPeriod::EXCLUDE_START_DATE, true);
        $period->toggleOptions(CarbonPeriod::EXCLUDE_END_DATE, true);
        $this->period = $period;
    }

    public function calcPeriod($date_start, $date_end)
    {
        $this->getPeriod($date_start, $date_end);
        return $this->period;
    }
}
