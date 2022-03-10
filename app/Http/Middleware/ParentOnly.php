<?php

namespace App\Http\Middleware;

use Closure;

class ParentOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = "parent")
    {
        if (!auth()->guard($guard)->check()) {
            return redirect(route('firstpage'));
        }
        return $next($request);
    }
}
