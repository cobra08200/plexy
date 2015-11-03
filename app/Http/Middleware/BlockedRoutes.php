<?php

namespace App\Http\Middleware;

use Closure;

class BlockedRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session('firstRun') == 'triggered') {
            return $next($request);
        }

        return redirect('/');
    }
}
