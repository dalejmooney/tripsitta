<?php

namespace App\Http\Controllers;

use App\Models\BabysitterAddress;
use App\Models\Page;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(){
        $page = Page::forHook('home')->with('slideshows.medias')->firstOrFail();
        $countries = \Countries::getList();

        $list_active_babysitters = User::where('role', 'babysitter')->pluck('id');

        $locations = BabysitterAddress::distinct()
            ->where('town', '<>', '')
            ->where('country', '<>', '')
            ->whereIn('babysitter_id', $list_active_babysitters->toArray())
            ->orderBy('country')
            ->get(['town', 'country']);

        // @todo Change to dynamic db query later DONE ON LIVE
        $featured_babysitters = collect([
            collect(['name' => 'Stephanie', 'country' => 'GB', 'img' => Storage::url('_babysitters/a (1).jpg')]),
            collect(['name' => 'Anna', 'country' => 'GE', 'img' => Storage::url('_babysitters/a (2).jpg')]),
            collect(['name' => 'Lucy', 'country' => 'ES', 'img' => Storage::url('_babysitters/a (3).jpg')]),
            collect(['name' => 'Marta', 'country' => 'PL', 'img' => Storage::url('_babysitters/a (4).jpg')]),
        ]);
        $places = collect([
            collect(['town' => 'Barcelona, Spain', 'country' => 'ES', 'img' => Storage::url('_places/a (1).jpg')]),
            collect(['town' => 'Venezia, Italy', 'country' => 'IT', 'img' => Storage::url('_places/a (2).jpg')]),
            collect(['town' => 'Berlin, Germany', 'country' => 'DE', 'img' => Storage::url('_places/a (3).jpg')]),
            collect(['town' => 'Rio de Janeiro, Brazil', 'country' => 'BR', 'img' => Storage::url('_places/a (4).jpg')]),
        ]);

        return view('home', [
            'countries' => $countries,
            'countries_towns' => $locations,
            'featured_babysitters' => $featured_babysitters,
            'places' => $places,
            'page' => $page
        ]);
    }
}
