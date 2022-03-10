<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ParentActive
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
        if(Auth::guard('parent')->user() != null) {
            $parent = Auth::guard('parent')->user();
            if ($parent->status == 1) {
                return $next($request);
            } else {
                Auth::guard('parent')->logout();
                return redirect()->route('firstpage')->with('error','You are loggedout, administrator has inactive your profile!');
            }
        }
    }
}