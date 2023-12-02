<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;




    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         $notifications = Auth::check() ? Auth::user()->notifications : [];

    //         view()->share('notifications', $notifications);

    //         return $next($request);
    //     });
    // }
}
