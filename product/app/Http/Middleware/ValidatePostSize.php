<?php

namespace App\Http\Middleware;

use Closure;

class ValidatePostSize
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

        if ($request->server('CONTENT_LENGTH') > 1000000) {
            return response('Payload too large', 413);
        }

        return $next($request);
    }
}
