<?php

namespace App\Service;

use A17\Twill\Repositories\SettingRepository;
use Carbon\Carbon;

class BookingPrice extends BookingPriceBase
{
    public function __construct(string $booking_type, Carbon $start_date, Carbon $end_date, int $no_of_children = 1)
    {
        $this->setBookingType($booking_type)
            ->setStartDate($start_date)
            ->setEndDate($end_date)
            ->setNoOfChildren($no_of_children);

        $this->setPricing();
    }

    /**
     * Calculate booking price
     *
     * @return float
     */
    public function calculate() :float
    {
        return $this->getUnitPrice() * $this->getPeriodLength();
    }

    /**
     * @return false|float
     */
    public function calculateInCents()
    {
        return round($this->calculate() * 100);
    }

    /**
     * Calculate all possible options for number of children
     *
     * @return array
     */
    public function calculateAllOptions() :array
    {
        $array = [];

        for($i=0; $i<=5; $i++)
        {
            $array[$i] = $this->getUnitPrice($i) * $this->getPeriodLength();
        }

        return $array;
    }

    /**
     * Returns price per unit (hour or day) for 1st child + the extra per child
     * $no_of_children can be used to override
     *
     * @param null|int $no_of_children
     * @return float
     */
    private function getUnitPrice($no_of_children=null) :float
    {
        if($no_of_children !== null)
        {
            return $this->getBasePrice() + ($no_of_children * $this->getPerChildPrice());
        }

        return $this->getBasePrice() + ($this->getNoOfExtraChildren() * $this->getPerChildPrice());
    }

    /**
     * Set default pricing for testing purposes. Overrides the setPrice if used before calculate()
     * @param int $base_price
     * @param int $per_child_price
     */
    public function setDefaultPricing(int $base_price, int $per_child_price)
    {
        $this
            ->setBasePrice($base_price)
            ->setPerChildPrice($per_child_price);
    }

    /**
     * Set pricing depending of booking type
     */
    private function setPricing()
    {
        if($this->getBookingType() === 'babysitter')
        {
            $base_price = app(SettingRepository::class)->byKey('babysitter_base_price', 'booking_system_settings');
            $per_child_price = app(SettingRepository::class)->byKey('babysitter_extra_per_child', 'booking_system_settings');
        }
        else
        {
            $base_price = app(SettingRepository::class)->byKey('holiday_nanny_base_price', 'booking_system_settings');
            $per_child_price = app(SettingRepository::class)->byKey('holiday_nanny_extra_per_child', 'booking_system_settings');
        }

        $this->setBasePrice($base_price) ->setPerChildPrice($per_child_price);
    }
}
