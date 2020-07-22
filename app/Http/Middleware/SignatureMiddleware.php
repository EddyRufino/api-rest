<?php

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $header = 'X-Name')
    {
        // Es un after Middleware porque el $next se llama antes que los demás
        // Si el $next se llamará después que todo, sería un Before Middleware
        $response = $next($request);

        $response->headers->set($header, config('app.name'));

        return $response;
    }
}
