<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function show()
    {
        return view('login.login');
        // return View::make('login.login');
    }

    public function login(Request $request)
    {
        // $input = Input::all();
        $input = $request->all();

        $rules = [
            'email'=>'required',
            'password'=>'required'
        ];
        $messages = [
        ];
        $validator = Validator::make($input, $rules, $messages);
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator)
                ->withInput(); // Input::except('password')
        }
        
        $attempt = Auth::attempt([
            'email' => $input['email'],
            'password' => $input['password']
        ]);
        if (!$attempt) {
            return Redirect::to('login')
            ->withErrors(['fail'=>'電子郵件 或 密碼錯誤，請重新輸入。'])
            ->withInput(); // Input::except('password')
        }

        if(!Auth::user()->isUser){
            Auth::logout();
            return Redirect::to('login')
            ->withErrors(['fail'=>'帳號尚未啟用，請去您的信箱收信，並點擊啟動帳號。。'])
            ->withInput(); // Input::except('password')
        }
        

        return Redirect::intended('/')->with('message', '登入成功');
        
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');
    }

}
