<?php

namespace App\Http\Controllers\GroupManage;

use App\Group;
use App\HtmlBuilder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


class GroupManageController extends Controller
{
    public function show(){
        $message = [
            'groups' => Group::where('manager',Auth::user()->id)->get(),
            'status' => ['已加入','申請中']
        ];
        return View::make('groupManage.show',$message);
    }
    
    
    public function groupDetail(Request $request, $id){
        $group = Group::where('id',$id)->first();
        if($group == NULL){
            return Redirect::route('group.manage')->with('message-fail', '錯誤的群組資料。');
        }
        
        $message = [
            'group' => $group,
            'table' => (new HtmlBuilder())->setType("USER")->build(),
            'status' => ['checked',''],
            'apply' => User::where([['group',$id],['isApplying',true]])->get(),
            'member' => User::where([['group',$id],['isApplying',false]])->get(),
            
        ];
        
        return View::make('groupManage.detail',$message);
    }
    
    public function groupUpdate(Request $request, $id){
        $group = Group::where('id',$id)->first();
        if($group == NULL){
            return Redirect::route('group.manage')->with('message-fail', '錯誤的群組資料。');
        }
        
        $rules = [
            'group_name' => 'required',
        ];
        $messages = [
            'group_name.required' => '群組名稱 不能留空。',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('group.detail', ['id'=>$id])
            ->withErrors($validator)
            ->withInput();
        }
        
        $group->name = $request->group_name;
        $group->remarks = $request->group_remarks;
        $group->canApply = $request->group_apply == NULL;
        $group->save();
        
        $message = [
            'group' => $group,
            'table' => (new HtmlBuilder())->setType("USER")->build(),
            'status' => ['checked',''],
            
        ];
        return Redirect::route('group.detail', ['id'=>$id])->with('message', '群組資料儲存成功。');
    }
    
    public function groupApply(Request $request, $gid){
        $group = Group::where('id',$gid)->first();
        if($group == NULL){
            return Redirect::route('group.manage')->with('message-fail', '錯誤的群組資料。');
        }
        
        $checkboxes = $request->input('user_apple');
        
        $str = "";
        foreach($checkboxes as $uid) {
            $user = User::find($uid);
            if($user->group != $gid){
                continue;
            }
            
            $user->isApplying = false;
            $user->save();
        }

        //$len = $request->input('user_apple');
        
        

        return Redirect::route('group.detail', ['id'=>$gid])->with('message', '群組資料儲存成功。');
    }
    
    
}