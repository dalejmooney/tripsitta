<?php

namespace App\Http\Controllers;
use App\Http\Requests\bookingCreateRequest;
use App\Http\Requests\babysitterBookingSaveRequest;
use App\Http\Requests\holidayNannyBookingSaveRequest;
use App\Mail\AdminChatMessageReceived;
use App\Mail\AdminNewBookingMade;
use App\Mail\NewBabysitterBookingConfirmationParent;
use App\Mail\NewHolidayNannyBookingConfirmationParent;
use App\Models\Booking;
use App\Models\BookingAddress;
use App\Models\BookingStatus;
use App\Models\Family;
use App\Models\FamilyAddress;
use App\Service\BookingPrice;
use App\Traits\BabysitterAvailabilitySearch;
use App\Traits\BookingChecks;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class BookingController extends Controller
{
    use BookingChecks;

    public function showBabysitterForm(User $user, Collection $location, Carbon $start_datetime, Carbon $end_datetime)
    {
        if(!$this->validDates('babysitter', $start_datetime, $end_datetime))
        {
            return redirect()
                ->route('search-local-babysitter')
                ->with('message', 'Incorrect date selected. Please adjust your search requirements and try again.');
        }

        if(!$this->isSelectedBabysitterAvailable($user->id, $start_datetime, $end_datetime, $location->toArray()))
        {
            return redirect()
                ->route('search-local-babysitter')
                ->with('message', 'Selected babysitter is not available for the selected period. Please adjust your search requirements and try again.');
        }

        $this->createPendingBookingSession('babysitter', $location, null, $start_datetime, $end_datetime, $user->id);
        $booking_estimate = new BookingPrice('babysitter', $start_datetime, $end_datetime);
        $parent_children = null;
        if(!is_null(auth()->user()))
        {
            $parent_children = Family::where('id', auth()->id())->with('children')->first();
        }

        return view('booking.book-now', [
            'type' => 'babysitter',
            'user' => $user,
            'start_date' => $start_datetime,
            'start_date_formatted' => $start_datetime->format('D, d M Y H:i'),
            'end_date' => $end_datetime,
            'end_date_formatted' => $end_datetime->format('D, d M Y H:i'),
            'booking_length' => $end_datetime->diff($start_datetime),
            'booking_length_formatted' => $end_datetime->longAbsoluteDiffForHumans($start_datetime, 3),
            'location' => $location,
            'price_estimate' => $booking_estimate->calculateAllOptions(),
            'parent_children' => $parent_children,
            'has_booking_session' => session()->has('booking_session'),
            'booking_session_children_details' => session()->has('booking_session') && array_key_exists('children', session()->get('booking_session')) ? session()->get('booking_session')['children'] : [],
        ]);
    }

    public function showHolidayNannyForm(User $user, Collection $start_location, Collection $end_location, Carbon $start_date, Carbon $end_date)
    {
        if(!$this->validDates('holiday_nanny', $start_date, $end_date))
        {
            return redirect()
                ->route('search-holiday-nanny')
                ->with('message', 'Incorrect date selected. Please adjust your search requirements and try again.');
        }

        if(!$this->isSelectedHolidayNannyAvailable($user->id, $start_date, $end_date))
        {
            return redirect()
                ->route('search-holiday-nanny')
                ->with('message', 'Selected holiday nanny is not available for the selected period. Please adjust your search requirements and try again.');
        }

        $this->createPendingBookingSession('holiday_nanny', $start_location, $end_location, $start_date, $end_date, $user->id);
        $booking_estimate = new BookingPrice('holiday_nanny', $start_date, $end_date);

        $parent_children = null;
        if(!is_null(auth()->user()))
        {
            $parent_children = Family::where('id', auth()->id())->with('children')->first();
        }

        return view('booking.book-now', [
            'type' => 'holiday_nanny',
            'user' => $user,
            'start_date' => $start_date,
            'start_date_formatted' => $start_date->format('D, d M Y'),
            'end_date' => $end_date,
            'end_date_formatted' => $end_date->format('D, d M Y'),
            'booking_length' => $end_date->diff($start_date),
            'booking_length_formatted' => $end_date->longAbsoluteDiffForHumans($start_date, 3),
            'start_location' => $start_location,
            'end_location' => $end_location,
            'price_estimate' => $booking_estimate->calculateAllOptions(),
            'parent_children' => $parent_children,
            'has_booking_session' => session()->has('booking_session'),
            'booking_session_children_details' => session()->has('booking_session') && array_key_exists('children', session()->get('booking_session')) ? session()->get('booking_session')['children'] : [],
        ]);
    }

    private function createPendingBookingSession($type, Collection $start_location, $end_location, Carbon $start_date, Carbon $end_date, int $babysitter_id){
        if(!session()->has('booking_session'))
        {
            request()->session()->push('booking_session', []);
        }

        session()->put('booking_session.type', $type);
        session()->put('booking_session.start_location', $start_location->toArray());
        session()->put('booking_session.end_location', (!is_null($end_location)) ? $end_location->toArray() : []);
        session()->put('booking_session.start_date', $start_date->format('Y-m-d H:i'));
        session()->put('booking_session.end_date', $end_date->format('Y-m-d H:i'));
        session()->put('booking_session.duration', $end_date->floatDiffInHours($start_date));
        session()->put('booking_session.babysitter_id', $babysitter_id);
        session()->put('booking_session.step', 1);
        session()->put('booking_session.return_parameters', request()->route()->originalParameters());
    }

    public function bookingCreate(bookingCreateRequest $request)
    {
        $validated = $request->validated();

        $this->updatePendingBookingSession($validated['children'], $validated['children_notes']);

        if(auth()->guest()){
            return redirect('login')->with('message', 'Please login to continue with the booking. If you don\'t have an account yet, please register to continue.');
        }

        return redirect('book-now-2');
    }

    private function updatePendingBookingSession(array $children_details, string $children_notes)
    {
        session()->put('booking_session.children', $children_details);
        session()->put('booking_session.children_notes', $children_notes);
        session()->put('booking_session.step', 2);
    }

    public function bookingPaymentForm()
    {
        $booking_session = session()->get('booking_session');
        $babysitter = User::with(['babysitter.mainAddress'])->findOrFail($booking_session['babysitter_id']);

        $start_date = Carbon::createFromFormat('Y-m-d H:i', $booking_session['start_date']);
        $end_date = Carbon::createFromFormat('Y-m-d H:i', $booking_session['end_date']);

        $booking_estimate = new BookingPrice($booking_session['type'], $start_date, $end_date, count($booking_session['children']));

        $format = 'D, d M Y';
        if ($booking_session['type'] === 'babysitter') {
            $format = 'D, d M Y H:i';
        }

        $countries = \Countries::getList();

        $original_booking_session = sha1(time());
        session()->put('booking_session.original_booking_session', $original_booking_session);

        try{
            Stripe::setApiKey(config('tripsitta.stripe.secret'));
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'name' => 'Babysitting booking for '. count($booking_session['children']).' '.str_plural('child', count($booking_session['children'])),
                    'description' => 'From: '.$booking_session['start_date'].' to '.$booking_session['end_date'],
                    'amount' => $booking_estimate->calculateInCents(),
                    'currency' => 'eur',
                    'quantity' => 1,
                ]],
                "metadata" => [
                    "new_booking" => true,
                    "original_booking_session" => $original_booking_session,
                ],
                'success_url' => route('book-now-summary', "").'/{CHECKOUT_SESSION_ID}',
                'cancel_url' => route('book-now-payment'),
            ]);
            $session_id = $session->id;
        } catch ( ApiErrorException $e)
        {
            $session_id = null;
        }

        session()->put('booking_session.stripe_session_id', $session_id);

        return view('booking.book-now-payment', [
            'babysitter' => $babysitter,
            'user' => auth()->user(),
            'type' => $booking_session['type'],
            'location' => collect($booking_session['start_location']),
            'start_location' => collect($booking_session['start_location']),
            'end_location' => array_key_exists('end_location', $booking_session) ? collect($booking_session['end_location']) : null,
            'start_date' => $start_date,
            'start_date_formatted' => $start_date->format($format),
            'end_date' => $end_date,
            'end_date_formatted' => $end_date->format($format),
            'booking_length' => $end_date->diff($start_date),
            'booking_length_formatted' => $end_date->longAbsoluteDiffForHumans($start_date, 3),
            'price_estimate' => $booking_estimate->calculateAllOptions(),
            'return_parameters' => $booking_session['return_parameters'],
            'has_booking_session' => session()->has('booking_session'),
            'booking_session_children_details' => session()->has('booking_session') && array_key_exists('children', session()->get('booking_session')) ? session()->get('booking_session')['children'] : [],
            'countries' => $countries,
            'stripe_session_id' => $session_id,
        ]);
    }

    public function saveBabysitterBooking(babysitterBookingSaveRequest $request){
        // @todo add final availability check
        // @todo improve availability check so it actually sees bookings that are confirmed
        // @todo rename action and request

        DB::beginTransaction();

        $booking_session = session()->get('booking_session');

        $start_date = Carbon::createFromFormat('Y-m-d H:i', $booking_session['start_date']);
        $end_date = Carbon::createFromFormat('Y-m-d H:i', $booking_session['end_date']);

        $booking_estimate = new BookingPrice($booking_session['type'], $start_date, $end_date, count($booking_session['children']));

        try {
            // Add booking address
            $address = null;
            if($booking_session['type'] === 'babysitter')
            {
                if ($request->get('address_type') === 'new') {
                    $address = BookingAddress::insertGetId($request->validated()['bookingAddress']);
                } elseif ($request->get('address_type') === 'home') {
                    $family_address = FamilyAddress::where('family_id', \Auth::id())->first(['address1', 'address2', 'town', 'postcode', 'country']);
                    $address = BookingAddress::insertGetId($family_address->toArray());
                }
            }


            // Add booking
            $booking = new Booking();
            $booking->family_id = \Auth::id();
            $booking->babysitter_id = $booking_session['babysitter_id'];
            $booking->type = $booking_session['type'];
            $booking->start = $start_date;
            $booking->end = $end_date;
            $booking->status_id = BookingStatus::getNewBookingStatus()->first()->id;
            $booking->booking_address_id = $address;
            $booking->contactable_main_phone_number = $request->get('primary_number_available', 0);
            $booking->contactable_emergency_phone_number = $request->get('emergency_phone_number_available', 0);
            $booking->alternative_phone_number = $request->get('additional_phone_number');
            $booking->booking_notes = $request->get('booking_notes');
            $booking->children_notes = $booking_session['children_notes'];

            if($booking_session['type'] === 'babysitter')
            {
                // babysitting booking
                $booking->parent_location_during_booking = $request->get('parent_during_booking');
            }
            else
            {
                // holiday nanny booking
                $booking->start_location = $booking_session['start_location']['country_code'];
                $booking->end_location = $booking_session['end_location']['country_code'];
                $booking->start_location_airport = $request->get('start_location_airport');
                $booking->destination_town = $request->get('destination_town');
                $booking->accommodation_booked = $request->get('accommodation_booked', 0);
                $booking->accommodation_details = $request->get('accommodation_details');
                $booking->babysitter_meet = $request->get('babysitter_meet', 0);
                $booking->babysitter_meet_details = $request->get('babysitter_meet_details');
                $booking->travel_trip = $request->get('travel_trip', 0);
                $booking->travel_trip_details = $request->get('travel_trip_details');
            }

            $booking->original_booking_session = $booking_session['original_booking_session'];
            $booking->save();

            // Add children to booking
            foreach($booking_session['children'] as $i => $child)
            {
                $booking->bookingChildren()->create(['name' => $child['name'], 'dob' => Carbon::createFromFormat('d/m/Y', $child['dob'])]);
            }

            // Create invoice
            $booking->createInvoice('balance', $booking_estimate->calculateInCents());

            // Send email confirmation to parent
            $parent = User::findOrFail(\Auth::id());
            $babysitter = User::findOrFail($booking_session['babysitter_id']);

            if($booking_session['type'] === 'babysitter'){
                \Mail::to($parent->email)->send(new NewBabysitterBookingConfirmationParent(
                    $parent->name,
                    $start_date,
                    $end_date,
                    $babysitter->name
                ));
            }
            else{
                \Mail::to($parent->email)->send(new NewHolidayNannyBookingConfirmationParent(
                    $parent->name,
                    $start_date,
                    $end_date,
                    $babysitter->name
                ));
            }

            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            Log::emergency('Booking db transaction failed', ['db' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
            return response()->json(['errors' => ['Error occurred when creating a booking for you. Please try again or contact us.']], 500);
        }

        // Update session details so customer can come back to the form if payment cancelled
        session()->put('booking_session.step', 3);
        session()->put('booking_session.booking_id', $booking->id);
        session()->put('booking_session.primary_number_available', $request->get('primary_number_available', 0));
        session()->put('booking_session.emergency_phone_number_available', $request->get('emergency_phone_number_available', 0));
        session()->put('booking_session.additional_phone_number', $request->get('additional_phone_number'));
        session()->put('booking_session.booking_notes', $request->get('booking_notes'));

        if($booking_session['type'] === 'babysitter')
        {
            session()->put('booking_session.address_type', $request->get('address_type'));
            session()->put('booking_session.parent_during_booking', $request->get('parent_during_booking'));
        }
        else
        {
            session()->put('booking_session.start_location_airport', $request->get('start_location_airport'));
            session()->put('booking_session.destination_town', $request->get('destination_town'));
            session()->put('booking_session.accommodation_booked', $request->get('accommodation_booked'));
            session()->put('booking_session.accommodation_details', $request->get('accommodation_details'));
            session()->put('booking_session.babysitter_meet', $request->get('babysitter_meet'));
            session()->put('booking_session.babysitter_meet_details', $request->get('babysitter_meet_details'));
            session()->put('booking_session.travel_trip', $request->get('travel_trip'));
            session()->put('booking_session.travel_trip_details', $request->get('travel_trip_details'));
        }

        // Email admin about new booking
        \Mail::to(config('tripsitta.admin_email'))->send(new AdminNewBookingMade(
            $booking->id,
            route('admin.bookings.edit', $booking->id)
        ));

        return response()->json(['success' => 'Booking saved, redirecting to payment ']);
    }


    public function showSummaryPage($stripe_session_id){
        // adjust for holiday nanny as well.

        $booking_session = session()->get('booking_session');

        $babysitter = User::with(['babysitter'])->findOrFail($booking_session['babysitter_id']);

        $start_date = Carbon::createFromFormat('Y-m-d H:i', $booking_session['start_date']);
        $end_date = Carbon::createFromFormat('Y-m-d H:i', $booking_session['end_date']);

        $format = 'D, d M Y';
        if ($booking_session['type'] === 'babysitter') {
            $format = 'D, d M Y H:i';
        }

        $booking_estimate = new BookingPrice($booking_session['type'], $start_date, $end_date, count($booking_session['children']));

        session()->put('booking_session', []);

        return view('booking.book-now-summary', [
            'babysitter' => $babysitter,
            'type' => $booking_session['type'],
            'booking_id' => $booking_session['booking_id'],
            'location' => collect($booking_session['start_location']),
            'start_location' => collect($booking_session['start_location']),
            'end_location' => array_key_exists('end_location', $booking_session) ? collect($booking_session['end_location']) : null,
            'start_date' => $start_date,
            'start_date_formatted' => $start_date->format($format),
            'end_date' => $end_date,
            'end_date_formatted' => $end_date->format($format),
            'booking_length' => $end_date->diff($start_date),
            'booking_length_formatted' => $end_date->longAbsoluteDiffForHumans($start_date, 3),
            'price_estimate' => $booking_estimate->calculateAllOptions(),
            'booking_session_children_details' => session()->has('booking_session') && array_key_exists('children', session()->get('booking_session')) ? session()->get('booking_session')['children'] : [],
        ]);
    }
}
