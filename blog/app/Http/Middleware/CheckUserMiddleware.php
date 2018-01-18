<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Closure;

class CheckUserMiddleware
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
        $isUser = Auth::User()->isUser;
        if ($isUser){
            return $next($request);
        }else{
            return Redirect::route('userProfile.read')->with('message', '請先輸入基本資料，才可使用其他功能，謝謝');
        }
    }
}
