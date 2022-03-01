<?php

namespace App\Http\Controllers;

use App\Http\Requests\holidayNannySearchRequest;
use App\Models\Babysitter;

use App\Models\Page;
use App\Traits\BookingChecks;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HolidayNannySearchController extends Controller
{
    use BookingChecks;

    // Show page with all possible nannies (no search criteria)
    public function index()
    {
        if(request()->session()->has('last_searched') && request()->session()->get('last_searched')['type'] === 'holiday_nanny')
        {
            return $this->showLastSearchedResults();
        }

        return redirect()->route('holiday-nanny-show-all');
    }

    // Show last searched results if GET and last_searched session exists.
    private function showLastSearchedResults()
    {
        $sess = request()->session()->get('last_searched');

        $last_requested = new holidayNannySearchRequest();
        $last_requested->setMethod('POST');
        $last_requested->request->add($sess);

        return $this->search($last_requested);
    }

    // Do an actual search and return only available nannies that match requirements
    public function search(holidayNannySearchRequest $request){
        $page = Page::forHook('search-holiday-nanny')->with('slideshows.medias')->firstOrFail();
        $countries = \Countries::getList();

        $this->saveLastSearchedToSession('holiday_nanny', $request);

        $start_date = Carbon::createFromFormat('d/m/Y', $request->get('start_date'));
        $return_date = Carbon::createFromFormat('d/m/Y', $request->get('return_date'));

        $nannies = collect([]);
        $available_languages = collect([]);

        if($valid_booking_window = $this->validDates('holiday_nanny', $start_date, $return_date)) {
            $nannies = $this->getAvailableHolidayNannies($start_date, $return_date);

            $available_languages = collect([]);
            foreach ($nannies as $babysitter) {
                if (!empty($babysitter->languages)) {
                    foreach ($babysitter->languages as $language) {
                        $available_languages->add($language->language_name);
                    }
                }
            }
            $available_languages = $available_languages->unique()->sort();
        }

        return view('search', [
            'page' => $page,
            'countries' => $countries,
            'nannies' => $nannies,
            'search_params' => $request->only(['travel_from', 'travel_to', 'start_date', 'return_date']),
            'start_date' => $start_date,
            'end_date' => $return_date,
            'available_languages' => $available_languages,
            'price_base' => 160,
            'price_extra_per_child' => 20,
            'valid_booking_window' => $valid_booking_window,
        ]);
    }

    // Save last searched parameters to session so we can re-use it
    private function saveLastSearchedToSession($type, holidayNannySearchRequest $request)
    {
        request()->session()->replace([
            'last_searched' => [
                'type' => $type,
                'travel_from' => $request->get('travel_from'),
                'start_date' => $request->get('start_date'),
                'travel_to' => $request->get('travel_to'),
                'return_date' => $request->get('return_date'),
            ]
        ]);
    }

    public function showAll()
    {
        request()->session()->remove('last_searched');

        $page = Page::forHook('search-holiday-nanny')->with('slideshows.medias')->firstOrFail();
        $countries = \Countries::getList();
        $nannies = Babysitter::with(['user', 'reviewsAverage', 'reviews', 'languages'])->active()->acceptsNannyJobs()->get();

        $available_languages = collect([]);
        foreach($nannies as $babysitter)
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

        return view('search', [
            'page' => $page,
            'countries' => $countries,
            'nannies' => $nannies,
            'available_languages' => $available_languages,
            'price_base' => 160,
            'price_extra_per_child' => 20,
        ]);
    }
}
