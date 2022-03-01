<?php

namespace App\Service;

use Carbon\Carbon;

class BookingPriceBase
{
    private $base_price = 0;
    private $per_child_price = 0;
    private $booking_type = ''; // babysitter OR holiday_nanny
    private $start_date;
    private $end_date;
    private $no_of_children = 0;

    // ---------

    /**
     * Set base price (hourly or daily).
     *
     * @param float $base_price
     * @return self
     */
    protected function setBasePrice(float $base_price)
    {
        $this->base_price = $base_price;
        return $this;
    }

    /**
     * Set per child price. It's then use din calculations times no of days / hours
     *
     * @param float $per_child_price
     * @return self
     */
    protected function setPerChildPrice(float $per_child_price)
    {
        $this->per_child_price = $per_child_price;
        return $this;
    }

    /**
     * @param string $type
     * @return self
     */
    protected function setBookingType(string $type)
    {
        $this->booking_type = $type;
        return $this;
    }

    /**
     * @param Carbon $date
     * @return self
     */
    protected function setStartDate(Carbon $date)
    {
        $this->start_date = $date;
        return $this;
    }

    /**
     * @param Carbon $date
     * @return self
     */
    protected function setEndDate(Carbon $date)
    {
        $this->end_date = $date;
        return $this;
    }

    /**
     * @param int $number
     * @return self
     */
    protected function setNoOfChildren(int $number)
    {
        $this->no_of_children = $number;
        return $this;
    }

    /**
     * Get base price
     *
     * @return float|int
     */
    public function getBasePrice()
    {
        return $this->base_price;
    }

    /**
     * Get per child price
     *
     * @return float|int
     */
    public function getPerChildPrice()
    {
        return $this->per_child_price;
    }

    /**
     * @return string
     */
    protected function getBookingType()
    {
        return $this->booking_type;
    }

    /**
     * Return type of pricing used by booking types. Hourly and daily are available for now.
     *
     * @return string
     */
    protected function getPricingType()
    {
        if($this->booking_type === 'babysitter')
        {
            return 'hourly';
        }

        return 'daily';
    }

    /**
     * @return null|Carbon
     */
    protected function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @return null|Carbon
     */
    protected function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Get booking period length. Returns hours or days depending on booking type
     *
     * @return float
     */
    protected function getPeriodLength() :float
    {
        if($this->getBookingType() === 'babysitter')
        {
            $diff = round($this->getEndDate()->floatDiffInHours($this->getStartDate()),1);
        }
        else
        {
            $diff = $this->getEndDate()->diffInDays($this->getStartDate());
        }

        return $diff;
    }

    /**
     * @return int
     */
    protected function getNoOfChildren() :int
    {
        return $this->no_of_children;
    }

    /**
     * Same as getNoOfChildren but ignores 1st child
     *
     * @return int
     */
    protected function getNoOfExtraChildren() :int
    {
        return $this->no_of_children - 1;
    }
}
