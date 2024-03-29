<?php

namespace App\Http\Middleware;

use Closure;

class httpsProtocol
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
      $request->setTrustedProxies( [ $request->getClientIp() ] );

      if (!$request->secure() && env('APP_ENV') === 'production') {

        return redirect()->secure($request->getRequestUri());

      }
      
      return $next($request);
    }
}
