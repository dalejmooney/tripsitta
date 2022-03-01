<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index($slug='home'){
        $page = Page::forSlug($slug)->where('published', 1)->first();

        if($page === null)
        {
            $page = Page::forInactiveSlug($slug)->where('published', 1)->firstOrFail();
            $active_slug = $page->slugs->filter(function ($value, $key) {
                return $value->active == 1;
            })->first();

            if($active_slug === null){
                return abort(404);
            }

            return redirect()->action(
                'PagesController@index', ['slug' => $active_slug->slug], 301
            );
        }

        return view('page-template', [
            'page' => $page
        ]);
    }
}
