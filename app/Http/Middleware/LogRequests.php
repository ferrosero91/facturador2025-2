<?php

namespace App\Http\Middleware;

use Closure;

class LogRequests
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
        if(env('LOG_ROUTES', false))
            \Log::info('Ruta accedida: ' . $request->path());
        return $next($request);
    }
}
