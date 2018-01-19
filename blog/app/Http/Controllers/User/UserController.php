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

class UserController extends Controller
{
    //
    public function read(){
        $user = Auth::user();
        return view('user.read')->with('user', $user);
    }

    public function show(){
        $user = Auth::user();
        if (!$user->isUser){
            Session::put('message', '請先新增個人資料');
            return view('user.userProfileUpdate');
        }
        $userProfile = UserProfile::where('user_id',$user->id)->first();
        return view('user.user')->with('userProfile', $userProfile);
    }
    
    public function edit(){
        return view('user.edit');
    }
    
    public function update(Request $request){
        $input = $request->all();
        
        $rules = [
            'username' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'group' => 'required',
        ];
        $messages = [
            'username.required' => '姓名 不能留空。',
            'nickname.required' => '暱稱 不能留空。',
            'nickname.max' => '暱稱 不能多於 255 個字元。',
        ];
        $validator = Validator::make($input, $rules, $messages);
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('user.edit')
            ->withErrors($validator)
            ->withInput();
        }
        
        $user = Auth::user();
        $user->username = $request->username;
        $user->nickname = $request->nickname;
        $user->group = $request->group;
        $user->remarks = $request->remarks;
        $user->save();
        
        return Redirect::route('user')->with('message', '帳號資料修改成功。');
    }
    
    
    public function pwdEdit(){
        return view('user.password');
    }
    public function pwdUpdate(Request $request){
        $input = $request->all();
        
        $rules = [
            'password' => 'required|string|min:6',
            'password2' => 'required|same:password',
        ];
        $messages = [
            
            'password2.required' => '暱稱 不能留空。',
            'password2.same' => '確認密碼 與 密碼 必須相同。'
        ];
        $validator = Validator::make($input, $rules, $messages);
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('user.password')
            ->withErrors($validator)
            ->withInput();
        }
        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();
        
        Auth::logout();
        return Redirect::route('login')->with('message', '密碼已經修改成功，請重新登入。');
    }
}
