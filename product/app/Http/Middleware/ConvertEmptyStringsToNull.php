<?php

namespace App\Http\Middleware;

use Closure;

class ConvertEmptyStringsToNull
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
        foreach ($request->input() as $key => $value) {
            if ($value === '') {
                $request->merge([$key => null]);
            }
        }

        return $next($request);
    }
}
