<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role1, $role2)
    {
        if(Auth::guard($role1)->check() && Auth::guard($role1)->user() != null){
            return $next($request);
        }elseif(Auth::guard($role2)->check() && Auth::guard($role2)->user() != null){
            return $next($request);
        }else{
            return redirect()->route('practice');
        }
    }
}
