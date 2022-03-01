<?php

namespace App\Providers;

use App\Events\BookingCompletedSuccessfully;
use App\Events\BookingConfirmed;
use App\Listeners\CreatePayoutRequest;
use App\Listeners\RemoveBabysitterAvailability;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        BookingCompletedSuccessfully::class => [
            CreatePayoutRequest::class,
        ],

        BookingConfirmed::class => [
            RemoveBabysitterAvailability::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
