<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Exception;
use Illuminate\Mail\Message;

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

        if(!Auth::user()->isActive){
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
    
    public function passwordReset(){
        return view('login.passwordReset');
    }
    
    public function passwordMail(Request $request)
    {
        $input = $request->all();
        $rules = [
            'email' => ['required', Rule::exists('users')->where(
            function ($query) use($request)
            {
                $query->where('email', $request->email);
                $query->where('isActive', 1);
        }) , ], ];
        $messages = ['email.exists' => '你所填寫的 電子郵件 無效。', ];
        $validator = Validator::make($input, $rules, $messages);
        
        // fails
        
        if ($validator->fails()) {
            return Redirect::route('password.reset')->withErrors($validator)->withInput();
        }
        
        $user = User::where('email', $request->email)->first();
         if($this->sendMail($user)){
             $user->save();
             return Redirect::route('login')->with('message','您的重置密碼信件已經寄出，請您去查收。');
         }else{
             return Redirect::route('password.reset')->with('message-fail','糟糕! 我們發生了錯誤，請重新在試一次或是聯絡管理員。');
         }
        
    }
    
    private function sendMail(User $user)
    {
        $current_time = Carbon::now()->addDays(1);

        $user->enable_url = hash('sha256', $user->email . $current_time->toDateTimeString());
        $user->expiry_date = $current_time;
        
        $data = ['name' => $user->username, 'email' => $user->email, 'url' => route('login.pwdUpdateByURL', ['key'=>$user->enable_url]) ];
        try
        {
            Mail::send('login.passwordMail', $data,
                function ($message) use ($user)
                {
                    $message->to($user->email, $user->username)->subject('減糖新運動會員密碼修改');
                    $message->from(env('MAIL_USERNAME'), 'admin');
            });
            return true;
        }
        
        catch(Exception $e)
        {
            throw $e;
            return false;
        }
    }
    
    public function pwdResetByURL($key){
        $user = User::where('enable_url', $key)->first();
        if($user == NULL || !$user->isActive || $user->expiry_date < Carbon::now()){
            return view('login.passwordResetUrl',['error'=>true]);
        }
        
        $message = [
            'error'=>false,
            'enable_key'=>$key,
            'email' => $user->email,
        ];
        return view('login.passwordResetUrl',$message);
    }
    public function pwdUpdateByURL(Request $request, $key){
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
            return Redirect::route('login.pwdUpdateByURL', ['key'=>$key])
            ->withErrors($validator)
            ->withInput();
        }
        $user = User::where('enable_url', $key)->first();
        if($user == NULL || !$user->isActive || $user->expiry_date < Carbon::now()){
            return view('login.pwdUpdateByURL');
        }
        $user->password = Hash::make($request->password);
        $user->enable_url = NULL;
        $user->expiry_date = NULL;
        $user->save();
        
        Auth::logout();
        return Redirect::route('login')->with('message', '密碼已經修改成功，請重新登入。');
    }
}
