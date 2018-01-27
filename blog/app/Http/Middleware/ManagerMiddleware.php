<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Closure;

class ManagerMiddleware
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
        //0 = root,  1 = manager,  2 = teacher,  3 = normal user
        if (Auth::User()->type <= 1){
            return $next($request);
        }else{
            return Redirect::route('user');
        }
    }
}
