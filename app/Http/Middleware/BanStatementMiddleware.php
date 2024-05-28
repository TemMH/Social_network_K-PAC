<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Statement;

use Illuminate\Support\Facades\Auth;
class BanStatementMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $statementId = $request->route('id'); //параметр id
        $statement = Statement::find($statementId);

        if ($statement && $statement->isBlocked()) {

            if (!Auth::check() || Auth::user()->role !== 'Admin') {
                return abort(403, 'Это видео заблокировано');
            }
        }

        return $next($request);
    }
}
