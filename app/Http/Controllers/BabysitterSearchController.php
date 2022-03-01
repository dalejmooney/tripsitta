<?php

namespace App\Http\Controllers;

use App\Http\Requests\babysitterSearchRequest;
use App\Models\Babysitter;
use App\Models\BabysitterAddress;
use App\Models\Page;
use App\Service\BookingPrice;
use App\Traits\BookingChecks;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BabysitterSearchController extends Controller
{
    use BookingChecks;

    // Show page with all possible babysitters (no search criteria)
    public function index(Request $request)
    {
        if($request->session()->has('last_searched') && $request->session()->get('last_searched')['type'] === 'babysitter')
        {
            return $this->showLastSearchedResults();
        }

        return redirect()->route('babysitter-show-all');
    }

    // Show last searched results if GET and last_searched session exists.
    private function showLastSearchedResults()
    {
        $sess = request()->session()->get('last_searched');

        $last_requested = new babysitterSearchRequest();
        $last_requested->setMethod('POST');
        $last_requested->request->add($sess);

        return $this->search($last_requested);
    }

    // Do an actual search and return only available babysitters that match requirements
    public function search(babysitterSearchRequest $request){
        $page = Page::forHook('search-babysitter')->with('slideshows.medias')->firstOrFail();
        $list_active_babysitters = User::where('role', 'babysitter')->pluck('id');
        $locations = BabysitterAddress::distinct()
            ->where('town', '<>', '')
            ->where('country', '<>', '')
            ->whereIn('babysitter_id', $list_active_babysitters->toArray())
            ->orderBy('country')
            ->get(['town', 'country']);

        $this->saveLastSearchedToSession('babysitter', $request);

        // get town and country name
        $search_address = explode(' - ', $request->get('location'));

        // get poss booking start date and time
        $start_date = (Carbon::createFromFormat('d/m/Y', $request->get('date')))
            ->setTimeFromTimeString($request->get('time'));

        // get poss booking end date and time
        $duration_minutes = $request->get('duration') * 60;
        $end_date = (new Carbon($start_date))->addMinutes($duration_minutes);

        $available_languages = collect([]);
        $babysitters = collect([]);

        if($valid_booking_window = $this->validDates('babysitter', $start_date, $end_date))
        {
            $babysitters = $this->getAvailableBabysitters($start_date, $end_date, $search_address);

            foreach($babysitters as $babysitter)
            {
                if(!empty($babysitter->languages))
                {
                    foreach($babysitter->languages as $language)
                    {
                        $available_languages->add($language->language_name);
                    }
                }
            }
            $available_languages = $available_languages->unique();
        }

        $booking_estimate = new BookingPrice('babysitter', $start_date, $end_date);

        return view('search-babysitters', [
            'page' => $page,
            'locations' => $locations,
            'babysitters' => $babysitters,
            'search_params' => $request->only(['location', 'date', 'duration', 'time']),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'available_languages' => $available_languages,
            'price_base' => $booking_estimate->getBasePrice(),
            'price_extra_per_child' => $booking_estimate->getPerChildPrice(),
            'valid_booking_window' => $valid_booking_window,
        ]);
    }

    // Save last searched parameters to session so we can re-use it
    private function saveLastSearchedToSession($type, babysitterSearchRequest $request)
    {
        request()->session()->replace([
            'last_searched' => [
                'type' => $type,
                'location' => $request->get('location'),
                'date' => $request->get('date'),
                'time' => $request->get('time'),
                'duration' => $request->get('duration'),
            ]
        ]);
    }

    public function showAll()
    {
        request()->session()->remove('last_searched');

        $page = Page::forHook('search-babysitter')->with('slideshows.medias')->firstOrFail();
        $list_active_babysitters = User::where('role', 'babysitter')->pluck('id');
        $locations = BabysitterAddress::distinct()
            ->where('town', '<>', '')
            ->where('country', '<>', '')
            ->whereIn('babysitter_id', $list_active_babysitters->toArray())
            ->orderBy('country')
            ->get(['town', 'country']);
        $babysitters = Babysitter::with(['user', 'reviewsAverage', 'reviews', 'languages', 'experienceAgeGroups'])->active()->acceptsBabysitterJobs()->get();

        $available_languages = collect([]);
        foreach($babysitters as $babysitter)
        {
            if(!empty($babysitter->languages))
            {
                foreach($babysitter->languages as $language)
                {
                    $available_languages->add($language->language_name);
                }
            }
        }
        $available_languages = $available_languages->unique()->sort();

        $booking_estimate = new BookingPrice('babysitter', Carbon::today(), Carbon::today());

        return view('search-babysitters', [
            'page' => $page,
            'locations' => $locations,
            'babysitters' => $babysitters,
            'available_languages' => $available_languages,
            'price_base' => $booking_estimate->getBasePrice(),
            'price_extra_per_child' => $booking_estimate->getPerChildPrice(),
        ]);
    }
}
