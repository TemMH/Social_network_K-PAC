<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function Laravel\Prompts\error;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {


        // if (Auth::check() && in_array(Auth::user()->role, ['Admin', 'Manager'])) {
        //     return $next($request);
        // }

        if (Auth::check() && Auth::user()->role === 'Admin') {
            return $next($request);
        }

        return abort(403, 'У вас нет прав администратора');
    }
}
