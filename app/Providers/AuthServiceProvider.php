<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\BookingInvoice;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Basic gates
        Gate::define('parentOnly', function(?User $user) {
            return $user && $user->role === 'parent';
        });

        Gate::define('parentOrGuest', function(?User $user) {
            if(is_null($user)) return true;
            return $user->role === 'parent';
        });

        Gate::define('babysitterOnly', function(?User $user) {
            return $user && $user->role === 'babysitter';
        });

        // Action based

        // Check if user is logged in as parent and has reached booking stage 2.
        Gate::define('makeBookingPayment', function(?User $user) {
            if(Gate::allows('parentOnly') && session()->has('booking_session'))
            {
                if(session()->get('booking_session.step') >= 2){
                    return true;
                }
            }

            return false;
        });

        Gate::define('seeBookingSummary', function(?User $user) {
            if(Gate::allows('parentOnly') && session()->has('booking_session'))
            {
                if(session()->get('booking_session.step') >= 3 && request()->stripe_session_id !== null)
                {
                    if(session()->has('booking_session.stripe_session_id') && request()->stripe_session_id === session()->get('booking_session.stripe_session_id'))
                    {
                        return true;
                    }
                }
            }

            return false;
        });

        Gate::define('doFinalRegistrationForFamily', function(?User $user) {
            if(is_null($user)) return false;

            $user->load('family');

            if($user->role === 'parent' &&
                $user->family->reg_step_1_completed == 1 && $user->family->reg_step_2_completed == 1 &&
                $user->family->reg_step_3_completed == 1
            ){
                return true;
            }

            return false;
        });

        Gate::define('doFinalRegistrationForBabysitter', function(?User $user) {
            if(is_null($user)) return false;

            $user->load('babysitter');

            if($user->role === 'babysitter' &&
                $user->babysitter->reg_step_1_completed == 1 && $user->babysitter->reg_step_2_completed == 1 &&
                $user->babysitter->reg_step_3_completed == 1 && $user->babysitter->reg_step_4_completed == 1
            ){
                return true;
            }

            return false;
        });

        Gate::define('viewBabysitterBookingDetails', function(?User $user, Booking $booking) {
            return $user->id === $booking->babysitter_id;
        });

        Gate::define('viewParentBookingDetails', function(?User $user, Booking $booking) {
            return $user->id === $booking->family_id;
        });

        Gate::define('leaveFeedbackParent', function(?User $user, Booking $booking) {
            return $user->id === $booking->family_id && !$booking->review()->exists();
        });

        Gate::define('viewParentInvoice', function(?User $user, BookingInvoice $invoice) {
            return $user->id === $invoice->booking->family_id;
        });

        Gate::define('viewBabysitterInvoice', function(?User $user, BookingInvoice $invoice) {
            return $user->id === $invoice->booking->babysitter_id;
        });
    }
}
