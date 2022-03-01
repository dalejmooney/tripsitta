<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BabysitterProfileController extends Controller
{
    public function show($slug)
    {
        $user = User::hasSlug($slug)->with(['babysitter'])->firstOrFail();

        $last_searched = [];
        if(request()->session()->has('last_searched') && !empty(request()->session()->get('last_searched')))
        {
            $last_searched = request()->session()->get('last_searched');

            if($last_searched['type'] === 'babysitter'){
                $search_address = explode(' - ', $last_searched['location']);

                // get poss booking start date and time
                $start_date = (Carbon::createFromFormat('d/m/Y', $last_searched['date']))
                    ->setTimeFromTimeString($last_searched['time']);

                // get poss booking end date and time
                $duration_minutes = $last_searched['duration'] * 60;
                $end_date = (new Carbon($start_date))->addMinutes($duration_minutes);

                $last_searched += ['start_date' => $start_date, 'return_date' => $end_date, 'search_address' => $search_address];
            }
        }

        $video_id = '';
        if(!empty($user->babysitter->video_url))
        {
            parse_str( parse_url( $user->babysitter->video_url, PHP_URL_QUERY ), $my_array_of_vars );
            $video_id = $my_array_of_vars['v'];
        }

        return view('babysitter-profile', [
            'user' => $user,
            'video_id' => $video_id,
            'last_searched' => $last_searched,
        ]);
    }
}
