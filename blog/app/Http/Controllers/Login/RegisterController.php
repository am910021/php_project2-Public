<?php

namespace App\Http\Controllers\Login;

use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Exception;


class RegisterController extends Controller
{
    //
    public function show()
    {
        return view('login.register');
        // return View::make('login.login');
    }

    public function register(Request $request)
    {
        $input = $request->all();

        $rules = [
            'email' => 'required|string|email|max:255|unique:users',
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
            return Redirect::to('register')
                ->withErrors($validator)
                ->withInput();
        }
        
        $current_time = Carbon::now()->addDays(1);
        
        $user = new User; 
        $user->email = $request->email;
        $user->username = $request->username;
        $user->nickname = $request->nickname;
        $user->password = Hash::make($request->password);
        $user->group = $request->group;
        $user->remarks = $request->remarks;
        $user->enable_url = hash('sha256', $request->email . $current_time->toDateTimeString());
        $user->expiry_date = $current_time;
               
        if($this->sendMail($user->username, $user->email, $user->enable_url)){
            $user->save();
            return Redirect::route('login')->with('message', '帳號申請成功，請您去信箱收信，並點擊啟動帳號。');
        }else {
            return Redirect::route('login')->with('message-fail', '帳號申請失敗，請您聯絡管理員。');
        }
        
        

        
    }

    private
    function sendMail($username, $email, $key)
    {
        $data = ['name' => $username, 'email' => $email, 'activate' => route('register.enable', $key) ];
        try
        {
            Mail::send('login.mail', $data,
                function ($message) use ($data)
                {
                    $message->to($data['email'], $data['name'])->subject('減糖新運動會員申請');
                    $message->from(env('MAIL_USERNAME'), 'admin');
            });
            return true;
        }
        
        catch(Exception $e)
        {
            return false;
        }
    }
    
    public function enable($key){
        $user = User::where('enable_url', $key)->first();
        if($user == NULL || $user->isActive || $user->expiry_date < Carbon::now()){
            return view('login.enable',['error'=>true]);
        }
        
        $message = [
            'error'=>false,
            'enable_key'=>$key,
            'email' => $user->email,
        ];
        
        
        return view('login.enable',$message);
    }
    
    
    public function  password(Request $request, $key){
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
            return Redirect::route('register.enable', ['key'=>$key])
            ->withErrors($validator)
            ->withInput();
        }
        $user = User::where('enable_url', $key)->first();
        if($user == NULL || $user->isActive || $user->expiry_date < Carbon::now()){
            return view('login.enable');
        }
        $user->password = Hash::make($request->password);
        $user->isActive = true;
        $user->enable_url = NULL;
        $user->expiry_date = NULL;
        $user->save();
        
        
        return Redirect::route('login')->with('message', '帳號啟用成功，請您由此登入謝謝。');
    }
    
}