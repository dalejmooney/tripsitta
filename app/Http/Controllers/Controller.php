<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    protected $user_id;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            if($request->route()->getPrefix() == '/parent' || $request->route()->getPrefix() == '/babysitter')
            {
                if (!\Auth::check()) {
                    return redirect('/login');
                }
                $this->user_id = \Auth::id(); // you can access user id here
            }
            return $next($request);
        });
    }
}
