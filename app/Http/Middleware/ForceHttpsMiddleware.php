<?php

namespace App\Http\Middleware;

use Closure;

class ForceHttpsMiddleware
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
        if (!$request->secure()) {
            \URL::forceScheme('https');
        }
        return $next($request);
    }
}
