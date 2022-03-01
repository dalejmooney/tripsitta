<?php

namespace Tests\Feature;

use App\Service\BookingPrice;
use Carbon\Carbon;
use Tests\TestCase;

class BookingPricingTest extends TestCase
{
    private function setTestCaseForBabysitter($expected_amount, Carbon $end_date, $no_children)
    {
        $start = new Carbon();
        $price = new BookingPrice('babysitter', $start, $end_date, $no_children);
        $price->setDefaultPricing(10, 5);
        $this->assertEquals($expected_amount, $price->calculate());
    }

    private function setTestCaseForHolidayNanny($expected_amount, Carbon $end_date, $no_children)
    {
        $start = new Carbon();
        $price = new BookingPrice('holiday_nanny', $start, $end_date, $no_children);
        $price->setDefaultPricing(100, 50);
        $this->assertEquals($expected_amount, $price->calculate());
    }

    public function testBabysitterBookingForOneChild()
    {
        $no_children = 1;

        $end = (new Carbon())->addHours(2);
        $this->setTestCaseForBabysitter(20, $end, $no_children);

        $end = (new Carbon())->addHours(5);
        $this->setTestCaseForBabysitter(50, $end, $no_children);

        $end = (new Carbon())->addHours(5)->addMinutes(30);
        $this->setTestCaseForBabysitter(55, $end, $no_children);

        $end = (new Carbon())->addHours(11);
        $this->setTestCaseForBabysitter(110, $end, $no_children);
    }

    public function testBabysitterBookingForTwoChildren()
    {
        $no_children = 2;

        $end = (new Carbon())->addHours(2);
        $this->setTestCaseForBabysitter(30, $end, $no_children);

        $end = (new Carbon())->addHours(5);
        $this->setTestCaseForBabysitter(75, $end, $no_children);

        $end = (new Carbon())->addHours(5)->addMinutes(30);
        $this->setTestCaseForBabysitter(82.5, $end, $no_children);

        $end = (new Carbon())->addHours(11);
        $this->setTestCaseForBabysitter(165, $end, $no_children);
    }

    public function testBabysitterBookingForThreeChildren()
    {
        $no_children = 3;

        $end = (new Carbon())->addHours(2);
        $this->setTestCaseForBabysitter(40, $end, $no_children);

        $end = (new Carbon())->addHours(5);
        $this->setTestCaseForBabysitter(100, $end, $no_children);

        $end = (new Carbon())->addHours(5)->addMinutes(30);
        $this->setTestCaseForBabysitter(110, $end, $no_children);

        $end = (new Carbon())->addHours(11);
        $this->setTestCaseForBabysitter(220, $end, $no_children);
    }

    public function testHolidayNannyBookingForOneChild()
    {
        $no_children = 1;

        $end = (new Carbon())->addDays(1);
        $this->setTestCaseForHolidayNanny(100, $end, $no_children);

        $end = (new Carbon())->addDays(5);
        $this->setTestCaseForHolidayNanny(500, $end, $no_children);

        $end = (new Carbon())->addDays(12);
        $this->setTestCaseForHolidayNanny(1200, $end, $no_children);

        $end = (new Carbon())->addDays(72);
        $this->setTestCaseForHolidayNanny(7200, $end, $no_children);
    }

    public function testHolidayNannyBookingForTwoChildren()
    {
        $no_children = 2;

        $end = (new Carbon())->addDays(1);
        $this->setTestCaseForHolidayNanny(150, $end, $no_children);

        $end = (new Carbon())->addDays(5);
        $this->setTestCaseForHolidayNanny(750, $end, $no_children);

        $end = (new Carbon())->addDays(12);
        $this->setTestCaseForHolidayNanny(1800, $end, $no_children);

        $end = (new Carbon())->addDays(72);
        $this->setTestCaseForHolidayNanny(10800, $end, $no_children);
    }

    public function testHolidayNannyBookingForThreeChildren()
    {
        $no_children = 3;

        $end = (new Carbon())->addDays(1);
        $this->setTestCaseForHolidayNanny(200, $end, $no_children);

        $end = (new Carbon())->addDays(5);
        $this->setTestCaseForHolidayNanny(1000, $end, $no_children);

        $end = (new Carbon())->addDays(12);
        $this->setTestCaseForHolidayNanny(2400, $end, $no_children);

        $end = (new Carbon())->addDays(72);
        $this->setTestCaseForHolidayNanny(14400, $end, $no_children);
    }
}
