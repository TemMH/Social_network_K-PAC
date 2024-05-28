<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class BanVideoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $videoId = $request->route('id'); //параметр id
        $video = Video::find($videoId);

        if ($video && $video->isBlocked()) {

            if (!Auth::check() || Auth::user()->role !== 'Admin') {
                return abort(403, 'Это видео заблокировано');
            }
        }

        return $next($request);
    }
}
