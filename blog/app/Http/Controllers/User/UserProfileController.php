<?php

namespace App\Http\Controllers\User;

use App\UserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class UserProfileController extends Controller
{
    
    public function read(){
        $user = Auth::user();
        if (!$user->isUser){
            return view('user.userProfileUpdate')
            ->with('message', '請先新增個人資料');
        }
        $userProfile = UserProfile::where('user_id',$user->id)->first();
        return view('user.userProfileRead')->with('userProfile', $userProfile);
    }

    public function store(Request $request){
        $user = Auth::user();
        if (!$user->isUser){
            return $this->create($request);
        }else{
            return $this->update($request);
        }
    }
    
    public function create(Request $request){
        $user = Auth::user();
        if ($user->isUser){
            return view('user.userProfileUpdate');
        }
        $input = $request->all();
        
        $rules = [
            'height' => 'required', 
            'weight' => 'required', 
            'sex' => 'required', 
            'activity_amount' => 'required', 
        ];
        $messages = [
            'height.required' => '必填', 
            'weight.required' => '必填', 
            'sex.required' => '必填', 
            'activity_amount.required' => '必填', 
        ];
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::route('userProfile.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        
        $userProfile = new UserProfile;
        $userProfile->age = $request->age;
        $userProfile->height = $request->height;
        $userProfile->weight = $request->weight;
        $userProfile->sex = $request->sex;
        $userProfile->activity_amount = $request->activity_amount;
        $userProfile->user_id = $user->id;  
        $userProfile->save();
        
        $user->isUser = TRUE;
        $user->save();

        return Redirect::route('userProfile.read')
            ->with('message', '新增成功');
    }
    
    public function edit(){
        $user = Auth::user();

        // is user
        $user_id = $user->id;
        $userProfile = UserProfile::where('user_id', '=', $user_id)->first();
        
        return view('user.userProfileUpdate')->with('userProfile', $userProfile);
    }

    public function update(Request $request){

        $input = $request->all();
        
        $rules = [
            'age' => 'required', 
            'height' => 'required', 
            'weight' => 'required', 
            'sex' => 'required', 
            'activity_amount' => 'required', 
        ];
        $messages = [
            'age.required' => '必填', 
            'height.required' => '必填', 
            'weight.required' => '必填', 
            'sex.required' => '必填', 
            'activity_amount.required' => '必填', 
        ];
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::route('userProfile.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        $userProfile = UserProfile::where('user_id',$user->id)->first();
        
        $userProfile->age = $request->age;
        $userProfile->height = $request->height;
        $userProfile->weight = $request->weight;
        $userProfile->sex = $request->sex;
        $userProfile->activity_amount = $request->activity_amount;
         
        $userProfile->save();
        
        return Redirect::route('userProfile.read')
            ->with('message', '修改成功');
    }

}
