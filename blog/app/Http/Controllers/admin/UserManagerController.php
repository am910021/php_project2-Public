<?php

namespace App\Http\Controllers\User;

use App\User;
use App\UserProfile;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserManagerController extends Controller
{
    public function show(){
        $user = Auth::user();
        if (!$user->isUser){
            Session::put('message', '請先新增個人資料');
            return view('user.userProfileUpdate');
        }
        $userProfile = UserProfile::where('user_id',$user->id)->first();
        return view('user.user')->with('userProfile', $userProfile);
    }
    
    
    
    
}