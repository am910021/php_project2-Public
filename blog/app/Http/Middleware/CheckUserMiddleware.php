<?php

namespace App\Http\Middleware;

use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
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
            $data = UserProfile::where('user_id',Auth::user()->id)->whereDate('updated_at', Carbon::today())->first();
            if($data == NULL){
                Session::put('need_to_be_updated', '');
            }
            return $next($request);
        }else{
            return Redirect::route('userProfile.read')->with('message', '請先輸入基本資料，才可使用其他功能，謝謝');
        }
    }
}
