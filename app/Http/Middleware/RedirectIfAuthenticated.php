<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()  && auth()->user()->role->id == 1) {
            return redirect('admin/dashboard');
        }elseif (Auth::guard($guard)->check()  && auth()->user()->role->id == 2){
            return redirect('author/dashboard');
        }else{
            return $next($request);
        }


    }
}
