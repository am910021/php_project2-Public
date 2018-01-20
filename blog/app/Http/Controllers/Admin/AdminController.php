<?php

namespace App\Http\Controllers\Admin;

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

class AdminController extends Controller
{
    public function show(){
        $message = [
            'root' => User::where('type',0)->count(),
            'group' => User::where('type',1)->count(),
            'teacher' => User::where('type',2)->count(),
            'normal' => User::where('type',3)->count(),
            
        ];
        return view('admin.admin', $message);
    }
    
    public function showUser(){
        $users = User::all();
        $status = ['停用','正常'];
        $statusClass = ['text-danger','text-success'];
        $typeStr = ['超級管理員','群組管理員','教師人員','一般會員'];
        
        $message = [
            'users'=>$users,
            'typeStr'=>$typeStr, 
            'status'=>$status,
            'statusClass'=>$statusClass,
        ];
        
        return view('admin.showUser',$message);
    }
    
    public function userEdit($id){
        $user = User::where('id',$id)->first();
        if($user == NULL){
            return Redirect::route('admin.showUser')->with('message-fail', '錯誤的會員資料。');
        }
        $status = ['checked',''];
        return view('admin.userEdit',['user'=>$user,'status'=>$status]);
    }
    
    public function userUpdate(Request $request, $id){
        $user = User::where('id',$id)->first();
        if($user == NULL){
            return Redirect::route('admin.userShow')->with('message-fail', '錯誤的會員資料。');
        }
        
        $rules = [
            'username' => 'required|string',
            'nickname' => 'required|string',
            'group' => 'required|numeric',
            'type' => 'required|numeric',
        ];
        $messages = [
            
            'group.numeric' => '請選擇有效的 群組。',
            'type.numeric' => '請選擇有效的 權限。'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('admin.userEdit', ['id'=>$id])
            ->withErrors($validator)
            ->withInput();
        }
        
        $user->username = $request->username;
        $user->nickname = $request->nickname;
        $user->group = $request->group;
        $user->remarks = $request->remarks;
        $user->type = $request->type;
        $user->isActive = $request->isActive == NULL;
        $user->save();
        
        return Redirect::route('admin.showUser')->with('message', '會員資料儲存成功。');
    }
}