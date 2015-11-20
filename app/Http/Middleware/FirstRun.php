<?php

namespace App\Http\Middleware;

use Closure;

class FirstRun
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
        if (env('TMDB_TOKEN') == null || env('PLEX_SERVER_URL') == null) {
            return redirect('setup')->with('firstRun', 'triggered');
        }

        return $next($request);
    }
}
