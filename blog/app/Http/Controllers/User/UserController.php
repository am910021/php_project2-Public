<?php

namespace App\Http\Controllers\User;

use App\Group;
use App\HtmlBuilder;
use App\User;
use App\UserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use App\MealRecord;
use Carbon\Carbon;
use App\Food;

class UserController extends Controller
{
    //
    public function read(){
        $message = [
            'user' => Auth::user(),
            'status' => ['已加入','申請中','被拒絕']
            
        ];
        return view('user.read')->with('user', $message);
    }

    public function show(){
        $user = Auth::user();
        if (!$user->isUser){
            return Redirect::route('userProfile.read')->with('message', '請先新增個人資料。');
        }
        
        $message = [
            'user' => Auth::user(),
            'status' => ['已加入','申請中','被拒絕'],
            'userProfile' => UserProfile::where('user_id',$user->id)->first(),
            'custom' => Food::where([['user_id',$user->id],['category',2]])->count(),
        ];
        
        return View::make('user.user',$message);
    }
    
    public function edit(){
        
        $html = (new HtmlBuilder())->setType("GROUP")->build();
        $groups = Group::all();
        return view('user.edit',['groups'=>$groups, 'html'=>$html]);
    }
    
    public function update(Request $request){
        $input = $request->all();
        
        $rules = [
            'username' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'group' => ['required', 'numeric', Rule::exists('groups','id')->where(
                function ($query) use ($request)
                {
                    if(Auth::user()->group != $request->group){
                        $query->where('canApply', true);
                    }
        }) , ],
        ];
        $messages = [
            'group.exists' => '所選擇的 群組 選項無效。',
            'group.numeric' => '所選擇的 群組 選項無效。',
            'group.required' => '群組 不能留空。',
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
        if($request->group==1){
            $user->group = 1;
            $user->isApplying = 0;
        }else if($user->group == $request->group){
            
        }else{
            $user->group = $request->group;
            $user->isApplying = 1;
        }

        $user->remarks = $request->remarks;
        $user->save();
        
        return Redirect::route('user')->with('message', '帳號資料儲存成功。');
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
            
            'password2.required' => '確認密碼 不能留空。',
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
    
    
    public function rank(){
        //$user = DB::table('meal_records')->selectRaw('count(user_id), user_id')->groupBy('user_id')->orderBy('user_id','DESC');
        if( Auth::user()->isApplying == 1 ){
            return View::make('user.rank');
        }
        
        
        $now = Carbon::today();
        $lastweek = Carbon::create($now->year,$now->month, $now->day, 0)->subWeek();
        $thisweek = Carbon::create($now->year,$now->month, $now->day, 0)->subWeek()->addDay(7);
        
        $datas2 = User::join('meal_records', 'meal_records.user_id', '=', 'users.id')
        ->selectRaw('(100-(SUM(meal_records.percent) / Count(DISTINCT DATE(meal_records.datetime))))*Count(DISTINCT DATE(meal_records.datetime)) as score, users.*')
        ->where([['users.group',Auth::user()->group],['users.isApplying',0]])
        ->whereDate('meal_records.datetime', '>=', $lastweek)->whereDate('meal_records.datetime', '<', $thisweek)
        ->groupBy('meal_records.user_id')->orderBy('score','DESC')->get();
        
        //return response()->json( $datas2);
        
        $rank = [null,null,null,null,null,null,null,null,null,null];
        $self = Null;
        $self_rank = 9999;
        foreach ($datas2 as $index=>$data){
            if($index <= 9){
                $rank[$index] = $data;
            }
            
            if($data->id == Auth::user()->id){
                $self = $data;
                $self_rank = $index;
            }
            
        }

        $message = [
            //'users' => $datas2,
            'rank' => $rank,
            'self' => $self,
            'self_rank' => $self_rank,
            'start_date' => Carbon::create($now->year,$now->month, $now->day, 0)->subWeek()->subDay(1)->toDateString(),
            'end_date' => Carbon::create($now->year,$now->month, $now->day, 0)->subWeek()->addDay(6)->toDateString(),
        ];
        
        
        
       return View::make('user.rank',$message);
    }
    
    public function foodList(){
        $message = [
            'list' => Food::where([['category',2],['user_id',Auth::user()->id]])->get(),
            
        ];
        
        return View::make('user.foodList',$message);
    }
    
}
