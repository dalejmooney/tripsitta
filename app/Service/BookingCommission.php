<?php

namespace App\Service;

use A17\Twill\Repositories\SettingRepository;
use App\Models\Booking;

class BookingCommission
{
    public function __construct(){}

    /**
     * Get the earnings and commission for selected booking
     *
     * @param Booking $booking
     * @return array
     */
    public function calculateForBooking(Booking $booking) :array
    {
        $booking->load('invoices');
        $invoices_total = $booking->invoices->sum('amount_due');

        $commission = $this->getCommissionPercentage($booking->type);
        return $this->calculate($commission, $invoices_total);
    }

    /**
     * Estimate the earnings and commission based on the expected booking total and booking type
     *
     * @param string $booking_type
     * @param int $amount_in_cents
     * @return array
     */
    public function estimate(string $booking_type, int $amount_in_cents) :array
    {
        $commission = $this->getCommissionPercentage($booking_type);
        return $this->calculate($commission, $amount_in_cents);
    }

    /**
     * Get commission percentage based on booking type
     *
     * @param string $booking_type
     * @return int
     */
    private function getCommissionPercentage(string $booking_type) :int
    {
        if($booking_type === 'babysitter')
        {
            $commission = app(SettingRepository::class)->byKey('babysitter_commission_percentage', 'booking_system_settings');
        }
        else
        {
            $commission = app(SettingRepository::class)->byKey('holiday_nanny_commission_percentage', 'booking_system_settings');
        }

        return (int) $commission;
    }

    /**
     * Calculate earnings share for admin and babysitter. Return amounts in cents
     *
     * @param int $commission_percentage
     * @param int $amount_in_cents
     * @return array
     */
    private function calculate(int $commission_percentage, int $amount_in_cents) :array
    {
        $for_admin = $amount_in_cents * ($commission_percentage / 100);
        $for_babysitter = $amount_in_cents - $for_admin;

        return [
            'for_babysitter' => (int) $for_babysitter,
            'for_admin' => (int) $for_admin,
        ];
    }
}
