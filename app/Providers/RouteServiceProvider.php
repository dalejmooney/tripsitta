<?php

namespace App\Providers;

use App\Extensions\ExtCountries;
use App\Models\BabysitterAddress;
use App\Models\BookingInvoice;
use App\Rules\CountryCode;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
//        Route::pattern('start_datetime', '^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$');
//        Route::pattern('start_date', '^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$');
//        Route::pattern('return_date', '^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$');

        Route::bind('account_type', function ($account_type) {
            if(in_array($account_type, ['parent', 'babysitter', 'any'])){
                return $account_type;
            }
            App::abort(404);
        });

        Route::bind('babysitter_slug', function ($babysitter_slug) {
            return User::hasSlug($babysitter_slug)->with(['babysitter'])->firstOrFail();
        });

        Route::bind('start_datetime', function ($start_datetime) {
            try{
                $start_datetime = Carbon::createFromFormat('Y-m-d\TH:i', $start_datetime)->roundMinute(30);
            }
            catch(\Exception $e){
                App::abort(404);
            }

            return $start_datetime;
        });

        Route::bind('end_datetime', function ($end_datetime) {
            try{
                $end_datetime = Carbon::createFromFormat('Y-m-d\TH:i', $end_datetime)->roundMinute(30);
            }
            catch(\Exception $e){
                App::abort(404);
            }

            return $end_datetime;
        });

        Route::bind('start_date', function ($start_date) {
            try{
                $start_date = Carbon::createFromFormat('Y-m-d', $start_date)->setTime(0,0);
            }
            catch(\Exception $e){
                App::abort(404);
            }

            return $start_date;
        });

        Route::bind('end_date', function ($end_date) {
            try{
                $end_date = Carbon::createFromFormat('Y-m-d', $end_date)->setTime(0,0);
            }
            catch(\Exception $e){
                App::abort(404);
            }

            return $end_date;
        });

        Route::bind('country_town', function ($country_town) {
            $search_address = explode(' - ', $country_town);

            if(count($search_address) == 2)
            {
                return collect([
                    'country_code' => trim(strtolower($search_address[0])),
                    'country_name' => \Countries::getOne(trim($search_address[0])),
                    'town' => trim($search_address[1])
                ]);
            }
            App::abort(404);
        });

        Route::bind('start_country', function ($start_country_name) {
            $country_code = ExtCountries::getCodeFromName($start_country_name);
            if($country_code !== '')
            {
                return collect([
                    'country_code' => strtolower($country_code),
                    'country_name' => $start_country_name,
                ]);
            }

            App::abort(404);
        });

        Route::bind('end_country', function ($end_country_name) {
            $country_code = ExtCountries::getCodeFromName($end_country_name);
            if($country_code !== '')
            {
                return collect([
                    'country_code' => strtolower($country_code),
                    'country_name' => $end_country_name,
                ]);
            }

            App::abort(404);
        });

        Route::bind('invoice_ref', function ($invoice_ref) {
            return BookingInvoice::where('reference', $invoice_ref)->firstOrFail();
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }
}
