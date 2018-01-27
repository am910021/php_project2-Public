<?php

namespace App\Http\Controllers\Admin;

use App\HtmlBuilder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use App\Group;

class AdminController extends Controller
{
    public function show(){
        $message = [
            'root' => User::where('type',0)->count(),
            'group' => User::where('type',1)->count(),
            'teacher' => User::where('type',2)->count(),
            'normal' => User::where('type',3)->count(),
            
            'groups' => Group::all()->count(),
            'inGroupMember' => User::where('group','>',1)->count(),
            'noGroupMember' => User::where('group',1)->orWhereNull('group')->count(),
            
        ];
        return View::make('admin.admin', $message);
    }
    
    public function showUser(){
        
        $users = null;
        if(Auth::user()->type==0){
            $users = User::all();
        }else if(Auth::user()->type==1){
            $users = User::where('type','>=','1')->get();
        }
        
        
        $status = ['停用','正常'];
        $statusClass = ['text-danger','text-success'];
        $typeStr = ['超級管理員','群組管理員','教師人員','一般會員'];
        
        $message = [
            'users'=>$users,
            'typeStr'=>$typeStr, 
            'status'=>$status,
            'statusClass'=>$statusClass,
        ];
        
        return View::make('admin.showUser',$message);
    }
    
    public function userEdit($id){
        $user = User::where([['id','=',$id],['type','>=',Auth::user()->type]])->first();
        if($user == NULL){
            return Redirect::route('admin.showUser')->with('message-fail', '錯誤的會員資料。');
        }
        $status = ['checked',''];
        
        $message = [
            'table' => (new HtmlBuilder())->setType("GROUP")->build(),
            'user'=>$user,
            'status'=>$status
        ];
        
        
        
        
        return view('admin.userEdit',$message);
    }
    
    public function userUpdate(Request $request, $id){
        $user = User::where([['id','=',$id],['type','>=',Auth::user()->type]])->first();
        if($user == NULL){
            return Redirect::route('admin.userShow')->with('message-fail', '錯誤的會員資料。');
        }
        
        $rules = [
            'username' => 'required|string',
            'nickname' => 'required|string',
            'group' => 'required|numeric',
            'type' => sprintf('required|numeric|between:%d,3',Auth::user()->type),
        ];
        $messages = [
            'group.numeric' => '請選擇有效的 群組。',
            'type.numeric' => '請選擇有效的 權限。',
            'type.between' => '請選擇有效的 權限。',
            'nickname.required'=> '暱稱 不能留空。'
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
    
    public function showGroup(){
        $message = [
            'groups' => Group::all(),
            'status' => ['不可加入','可加入'],
            'statusClass' => ['text-danger','text-success'],
            
        ];
        return View::make('admin.showGroup',$message);
    }
    
    public function groupCreate(){
        $message = [
            'table' => (new HtmlBuilder())->setType("USER")->build(),
        ];
        return View::make('admin.groupCreate',$message);
    }
    
    
    public function groupUpdate(Request $request){
        $rules = [
            'group_name' => 'required',
            'group_manager' => ['required', 'numeric', Rule::exists('users','id')->where('isActive', 1), ],
        
        ];
        $messages = [
            'group_name.required' => '群組名稱 不能留空。',
            'group_manager.exists' => '所選擇的 管理員 選項無效。',
            'group_manager.numeric' => '所選擇的 管理員 選項無效。',
            'group_manager.required' => '管理員 不能留空。',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('admin.groupCreate')
            ->withErrors($validator)
            ->withInput();
        }
        
        $group = new Group();
        $group->manager = $request->group_manager;
        $group->name = $request->group_name;
        $group->remarks = $request->group_remarks;
        $group->canApply = $request->group_apply == NULL;
        $group->save();
        
        return Redirect::route('admin.showGroup')->with('message', '群組資料新增成功。');
        
        
    }
    
    
    public function groupEdit($id){
        $group = Group::where('id',$id)->first();
        if($group == NULL){
            return Redirect::route('admin.showGroup')->with('message-fail', '錯誤的群組資料。');
        }
        
        
        $message = [
            'group' => $group,
            'table' => (new HtmlBuilder())->setType("USER")->build(),
            'status' => ['checked',''],
        ];
        return View::make('admin.groupEdit',$message);
    }
    
    public function groupUpdateById(Request $request, $id){
        $group = Group::where('id',$id)->first();
        if($group == NULL){
            return Redirect::route('admin.groupShow')->with('message-fail', '錯誤的群組資料。');
        }
        
        $rules = [
            'group_name' => 'required',
            'group_manager' => ['required', 'numeric', Rule::exists('users','id')->where('isActive', 1), ],

        ];
        $messages = [
            'group_name.required' => '群組名稱 不能留空。',
            'group_manager.exists' => '所選擇的 管理員 選項無效。',
            'group_manager.numeric' => '所選擇的 管理員 選項無效。',
            'group_manager.required' => '管理員 不能留空。',

//             'type.numeric' => '請選擇有效的 權限。'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('admin.groupEdit', ['id'=>$id])
            ->withErrors($validator)
            ->withInput();
        }
        
        $group->manager = $request->group_manager;
        $group->name = $request->group_name;
        $group->remarks = $request->group_remarks;
        $group->canApply = $request->group_apply == NULL;
        $group->save();
        
        return Redirect::route('admin.showGroup')->with('message', '群組資料儲存成功。');
    }
    
}