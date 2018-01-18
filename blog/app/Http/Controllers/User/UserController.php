<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function read(){
        $user = Auth::user();
        return view('user.read')->with('user', $user);
    }


}
